<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Models\Project;
use App\Models\User;
use App\Http\Requests\StoreBugRequest;
use App\Http\Requests\UpdateBugRequest;
use App\Services\ActivityLogService;
use App\Mail\BugAssigned;
use App\Mail\BugStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class BugController extends Controller
{
    public function index(Request $request)
    {
        $query = Bug::with(['project', 'reporter', 'assignee']);
        $user = auth()->user();

        // Role-based scoping
        if ($user->isDeveloper()) {
            $query->where('assigned_to', $user->id);
        } elseif ($user->isTester()) {
            $query->where('reporter_id', $user->id);
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $bugs = $query->latest()->paginate(15)->withQueryString();
        $projects = Project::all();
        $developers = User::whereHas('role', fn($q) => $q->where('name', 'developer'))->get();

        return view('bugs.index', compact('bugs', 'projects', 'developers'));
    }

    public function create()
    {
        $projects = Project::where('status', 'active')->get();
        $developers = User::whereHas('role', fn($q) => $q->where('name', 'developer'))->get();

        return view('bugs.create', compact('projects', 'developers'));
    }

    public function store(StoreBugRequest $request)
    {
        $data = $request->validated();
        $data['reporter_id'] = auth()->id();

        // Handle screenshot upload
        if ($request->hasFile('screenshot')) {
            $data['screenshot'] = $request->file('screenshot')->store('screenshots', 'public');
        }

        $bug = Bug::create($data);

        ActivityLogService::log('bug_created', "Bug '{$bug->title}' was created.", $bug);

        // Send email if bug is assigned
        if ($bug->assigned_to) {
            $assignee = User::find($bug->assigned_to);
            if ($assignee) {
                Mail::to($assignee->email)->send(new BugAssigned($bug));
            }
            ActivityLogService::log('bug_assigned', "Bug '{$bug->title}' was assigned to {$assignee->name}.", $bug);
        }

        return redirect()->route('bugs.index')->with('success', 'Bug reported successfully.');
    }

    public function show(Bug $bug)
    {
        $bug->load(['project', 'reporter', 'assignee', 'comments.user']);
        return view('bugs.show', compact('bug'));
    }

    public function edit(Bug $bug)
    {
        $projects = Project::where('status', 'active')->get();
        $developers = User::whereHas('role', fn($q) => $q->where('name', 'developer'))->get();

        return view('bugs.edit', compact('bug', 'projects', 'developers'));
    }

    public function update(UpdateBugRequest $request, Bug $bug)
    {
        $data = $request->validated();
        $oldStatus = $bug->status;
        $oldAssignee = $bug->assigned_to;

        // Handle screenshot upload
        if ($request->hasFile('screenshot')) {
            // Delete old screenshot
            if ($bug->screenshot) {
                Storage::disk('public')->delete($bug->screenshot);
            }
            $data['screenshot'] = $request->file('screenshot')->store('screenshots', 'public');
        }

        // Handle screenshot removal
        if ($request->has('remove_screenshot') && !$request->hasFile('screenshot')) {
            if ($bug->screenshot) {
                Storage::disk('public')->delete($bug->screenshot);
            }
            $data['screenshot'] = null;
        }

        $bug->update($data);

        ActivityLogService::log('bug_updated', "Bug '{$bug->title}' was updated.", $bug);

        // If status changed, send notification
        if ($oldStatus !== $bug->status) {
            ActivityLogService::log('bug_status_changed', "Bug '{$bug->title}' status changed from '{$oldStatus}' to '{$bug->status}'.", $bug);

            if ($bug->reporter) {
                Mail::to($bug->reporter->email)->send(new BugStatusChanged($bug, $oldStatus));
            }
        }

        // If assignee changed, notify new assignee
        if ($oldAssignee !== $bug->assigned_to && $bug->assigned_to) {
            $assignee = User::find($bug->assigned_to);
            if ($assignee) {
                Mail::to($assignee->email)->send(new BugAssigned($bug));
            }
            ActivityLogService::log('bug_assigned', "Bug '{$bug->title}' was assigned to {$assignee->name}.", $bug);
        }

        return redirect()->route('bugs.show', $bug)->with('success', 'Bug updated successfully.');
    }

    public function destroy(Bug $bug)
    {
        // Delete screenshot file
        if ($bug->screenshot) {
            Storage::disk('public')->delete($bug->screenshot);
        }

        $title = $bug->title;
        $bug->delete();

        ActivityLogService::log('bug_deleted', "Bug '{$title}' was deleted.");

        return redirect()->route('bugs.index')->with('success', 'Bug deleted successfully.');
    }
}
