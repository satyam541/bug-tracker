<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Services\ActivityLogService;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('creator')
            ->withCount('bugs')
            ->latest()
            ->paginate(15);

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $users = User::with('role')->get();
        return view('projects.create', compact('users'));
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        if ($request->has('members')) {
            $project->members()->sync($request->members);
        }

        ActivityLogService::log('project_created', "Project '{$project->name}' was created.", $project);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $project->load(['creator', 'members.role', 'bugs.reporter', 'bugs.assignee']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $users = User::with('role')->get();
        $project->load('members');
        return view('projects.edit', compact('project', 'users'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        if ($request->has('members')) {
            $project->members()->sync($request->members);
        }

        ActivityLogService::log('project_updated', "Project '{$project->name}' was updated.", $project);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $name = $project->name;
        $project->delete();

        ActivityLogService::log('project_deleted', "Project '{$name}' was deleted.");

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
