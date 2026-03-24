<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Models\Project;
use App\Models\User;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalUsers = User::count();
        $totalProjects = Project::count();
        $totalBugs = Bug::count();

        // Bug counts by status
        $openBugs = Bug::where('status', 'open')->count();
        $inProgressBugs = Bug::where('status', 'in_progress')->count();
        $fixedBugs = Bug::where('status', 'fixed')->count();
        $closedBugs = Bug::where('status', 'closed')->count();

        // Bugs by priority
        $bugsByPriority = Bug::selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority')
            ->toArray();

        // Bugs by severity
        $bugsBySeverity = Bug::selectRaw('severity, COUNT(*) as count')
            ->groupBy('severity')
            ->pluck('count', 'severity')
            ->toArray();

        // Project-wise bug count
        $projectBugCounts = Project::withCount('bugs')->get();

        // Recent bugs
        $recentBugs = Bug::with(['project', 'reporter', 'assignee'])
            ->latest()
            ->take(5)
            ->get();

        // Recent activities
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.index', compact(
            'totalUsers',
            'totalProjects',
            'totalBugs',
            'openBugs',
            'inProgressBugs',
            'fixedBugs',
            'closedBugs',
            'bugsByPriority',
            'bugsBySeverity',
            'projectBugCounts',
            'recentBugs',
            'recentActivities'
        ));
    }
}
