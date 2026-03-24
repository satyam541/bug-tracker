@extends('layouts.app')
@section('title', 'Project Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $project->name }}</h4>
            @php
                $statusColors = ['active' => 'success', 'inactive' => 'warning', 'completed' => 'secondary'];
            @endphp
            <span
                class="badge bg-{{ $statusColors[$project->status] ?? 'secondary' }}">{{ ucfirst($project->status) }}</span>
        </div>
        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="row g-4">
        <!-- Project Info -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white"><strong>Project Information</strong></div>
                <div class="card-body">
                    <p><strong>Created By:</strong> {{ $project->creator->name ?? 'N/A' }}</p>
                    <p><strong>Created:</strong> {{ $project->created_at->format('M d, Y') }}</p>
                    <p><strong>Last Updated:</strong> {{ $project->updated_at->format('M d, Y') }}</p>
                    @if ($project->description)
                        <hr>
                        <p class="mb-0">{{ $project->description }}</p>
                    @endif
                </div>
            </div>

            <!-- Members -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white"><strong>Team Members ({{ $project->members->count() }})</strong></div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($project->members as $member)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $member->name }}</span>
                                @php
                                    $roleColors = [
                                        'admin' => 'danger',
                                        'developer' => 'primary',
                                        'tester' => 'success',
                                    ];
                                @endphp
                                <span
                                    class="badge bg-{{ $roleColors[$member->role->name] ?? 'secondary' }}">{{ ucfirst($member->role->name ?? '') }}</span>
                            </div>
                        @empty
                            <div class="list-group-item text-muted">No members assigned.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Bugs -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <strong>Bugs ({{ $project->bugs->count() }})</strong>
                    @if (auth()->user()->hasRole('admin', 'tester'))
                        <a href="{{ route('bugs.create') }}?project_id={{ $project->id }}"
                            class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Report Bug
                        </a>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Assigned To</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($project->bugs as $bug)
                                    <tr>
                                        <td>{{ $bug->id }}</td>
                                        <td><a href="{{ route('bugs.show', $bug) }}">{{ Str::limit($bug->title, 35) }}</a>
                                        </td>
                                        <td>
                                            @php
                                                $sColors = [
                                                    'open' => 'warning',
                                                    'in_progress' => 'info',
                                                    'fixed' => 'success',
                                                    'closed' => 'secondary',
                                                ];
                                            @endphp
                                            <span
                                                class="badge bg-{{ $sColors[$bug->status] ?? 'secondary' }}">{{ $bug->status_label }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $pColors = [
                                                    'low' => 'success',
                                                    'medium' => 'info',
                                                    'high' => 'warning',
                                                    'critical' => 'danger',
                                                ];
                                            @endphp
                                            <span
                                                class="badge bg-{{ $pColors[$bug->priority] ?? 'secondary' }}">{{ ucfirst($bug->priority) }}</span>
                                        </td>
                                        <td>{{ $bug->assignee->name ?? 'Unassigned' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">No bugs reported for this
                                            project.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
