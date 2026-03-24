@extends('layouts.app')
@section('title', 'Bugs')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">All Bugs</h4>
        @if (auth()->user()->hasRole('admin', 'tester'))
            <a href="{{ route('bugs.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Report Bug
            </a>
        @endif
    </div>

    <!-- Filters -->
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('bugs.index') }}">
                <div class="row g-2 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            @foreach (['open', 'in_progress', 'fixed', 'closed'] as $s)
                                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                                    {{ str_replace('_', ' ', ucfirst($s)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Priority</label>
                        <select name="priority" class="form-select form-select-sm">
                            <option value="">All Priority</option>
                            @foreach (['low', 'medium', 'high', 'critical'] as $p)
                                <option value="{{ $p }}" {{ request('priority') == $p ? 'selected' : '' }}>
                                    {{ ucfirst($p) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Severity</label>
                        <select name="severity" class="form-select form-select-sm">
                            <option value="">All Severity</option>
                            @foreach (['minor', 'major', 'critical'] as $sv)
                                <option value="{{ $sv }}" {{ request('severity') == $sv ? 'selected' : '' }}>
                                    {{ ucfirst($sv) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Project</label>
                        <select name="project_id" class="form-select form-select-sm">
                            <option value="">All Projects</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}"
                                    {{ request('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Search</label>
                        <input type="text" name="search" class="form-control form-control-sm"
                            value="{{ request('search') }}" placeholder="Search bugs...">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100"><i class="bi bi-funnel me-1"></i>
                            Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bugs Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Severity</th>
                            <th>Assigned To</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bugs as $bug)
                            <tr>
                                <td>{{ $bug->id }}</td>
                                <td><a href="{{ route('bugs.show', $bug) }}"
                                        class="text-decoration-none fw-semibold">{{ Str::limit($bug->title, 30) }}</a></td>
                                <td><span class="text-muted small">{{ $bug->project->name ?? 'N/A' }}</span></td>
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
                                <td>
                                    @php
                                        $svColors = [
                                            'minor' => 'light text-dark',
                                            'major' => 'warning',
                                            'critical' => 'danger',
                                        ];
                                    @endphp
                                    <span
                                        class="badge bg-{{ $svColors[$bug->severity] ?? 'secondary' }}">{{ ucfirst($bug->severity) }}</span>
                                </td>
                                <td>{{ $bug->assignee->name ?? 'Unassigned' }}</td>
                                <td class="small text-muted">{{ $bug->created_at->format('M d') }}</td>
                                <td>
                                    <a href="{{ route('bugs.show', $bug) }}" class="btn btn-sm btn-outline-info"
                                        title="View"><i class="bi bi-eye"></i></a>
                                    @if (auth()->user()->hasRole('admin', 'developer'))
                                        <a href="{{ route('bugs.edit', $bug) }}" class="btn btn-sm btn-outline-primary"
                                            title="Edit"><i class="bi bi-pencil"></i></a>
                                    @endif
                                    @if (auth()->user()->isAdmin())
                                        <form action="{{ route('bugs.destroy', $bug) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this bug?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-3">No bugs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $bugs->links('pagination::bootstrap-5') }}
    </div>
@endsection
