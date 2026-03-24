@extends('layouts.app')
@section('title', 'Projects')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">All Projects</h4>
        @if (auth()->user()->isAdmin())
            <a href="{{ route('projects.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> New Project
            </a>
        @endif
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Project Name</th>
                            <th>Status</th>
                            <th>Bugs</th>
                            <th>Created By</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td>{{ $project->id }}</td>
                                <td><strong><a href="{{ route('projects.show', $project) }}"
                                            class="text-decoration-none">{{ $project->name }}</a></strong></td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'active' => 'success',
                                            'inactive' => 'warning',
                                            'completed' => 'secondary',
                                        ];
                                    @endphp
                                    <span
                                        class="badge bg-{{ $statusColors[$project->status] ?? 'secondary' }}">{{ ucfirst($project->status) }}</span>
                                </td>
                                <td><span class="badge bg-primary">{{ $project->bugs_count }}</span></td>
                                <td>{{ $project->creator->name ?? 'N/A' }}</td>
                                <td>{{ $project->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-info"
                                        title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if (auth()->user()->isAdmin())
                                        <a href="{{ route('projects.edit', $project) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Delete this project and all its bugs?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">No projects found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $projects->links('pagination::bootstrap-5') }}
    </div>
@endsection
