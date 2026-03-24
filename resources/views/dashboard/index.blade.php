@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $totalUsers }}</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-folder"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $totalProjects }}</div>
                        <div class="stat-label">Total Projects</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-bug"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $totalBugs }}</div>
                        <div class="stat-label">Total Bugs</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $openBugs }}</div>
                        <div class="stat-label">Open Bugs</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <span class="badge bg-warning text-dark fs-5 px-3 py-2">{{ $openBugs }}</span>
                    <p class="mt-2 mb-0 text-muted small">Open</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <span class="badge bg-info text-dark fs-5 px-3 py-2">{{ $inProgressBugs }}</span>
                    <p class="mt-2 mb-0 text-muted small">In Progress</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <span class="badge bg-success fs-5 px-3 py-2">{{ $fixedBugs }}</span>
                    <p class="mt-2 mb-0 text-muted small">Fixed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <span class="badge bg-secondary fs-5 px-3 py-2">{{ $closedBugs }}</span>
                    <p class="mt-2 mb-0 text-muted small">Closed</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white"><strong>Bugs by Status</strong></div>
                <div class="card-body">
                    <canvas id="statusChart" height="260"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white"><strong>Bugs by Priority</strong></div>
                <div class="card-body">
                    <canvas id="priorityChart" height="260"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white"><strong>Bugs by Severity</strong></div>
                <div class="card-body">
                    <canvas id="severityChart" height="260"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Bug Counts -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white"><strong>Bugs per Project</strong></div>
                <div class="card-body">
                    <canvas id="projectChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white"><strong>Recent Activities</strong></div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentActivities as $activity)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <i class="bi bi-activity text-primary me-2"></i>
                                        <strong>{{ $activity->user->name ?? 'System' }}</strong>
                                        <span class="text-muted">{{ $activity->description }}</span>
                                    </div>
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-muted">No recent activities.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bugs Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <strong>Recent Bugs</strong>
            <a href="{{ route('bugs.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
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
                            <th>Assigned To</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBugs as $bug)
                            <tr>
                                <td>{{ $bug->id }}</td>
                                <td><a href="{{ route('bugs.show', $bug) }}">{{ Str::limit($bug->title, 40) }}</a></td>
                                <td>{{ $bug->project->name ?? '-' }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'open' => 'warning',
                                            'in_progress' => 'info',
                                            'fixed' => 'success',
                                            'closed' => 'secondary',
                                        ];
                                    @endphp
                                    <span
                                        class="badge bg-{{ $statusColors[$bug->status] ?? 'secondary' }}">{{ $bug->status_label }}</span>
                                </td>
                                <td>
                                    @php
                                        $priorityColors = [
                                            'low' => 'success',
                                            'medium' => 'info',
                                            'high' => 'warning',
                                            'critical' => 'danger',
                                        ];
                                    @endphp
                                    <span
                                        class="badge bg-{{ $priorityColors[$bug->priority] ?? 'secondary' }}">{{ ucfirst($bug->priority) }}</span>
                                </td>
                                <td>{{ $bug->assignee->name ?? 'Unassigned' }}</td>
                                <td>{{ $bug->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">No bugs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Bugs by Status - Doughnut Chart
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Open', 'In Progress', 'Fixed', 'Closed'],
                datasets: [{
                    data: [{{ $openBugs }}, {{ $inProgressBugs }}, {{ $fixedBugs }},
                        {{ $closedBugs }}
                    ],
                    backgroundColor: ['#ffc107', '#0dcaf0', '#198754', '#6c757d'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Bugs by Priority - Bar Chart
        new Chart(document.getElementById('priorityChart'), {
            type: 'bar',
            data: {
                labels: ['Low', 'Medium', 'High', 'Critical'],
                datasets: [{
                    label: 'Bugs',
                    data: [
                        {{ $bugsByPriority['low'] ?? 0 }},
                        {{ $bugsByPriority['medium'] ?? 0 }},
                        {{ $bugsByPriority['high'] ?? 0 }},
                        {{ $bugsByPriority['critical'] ?? 0 }}
                    ],
                    backgroundColor: ['#198754', '#0dcaf0', '#ffc107', '#dc3545'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Bugs by Severity - Pie Chart
        new Chart(document.getElementById('severityChart'), {
            type: 'pie',
            data: {
                labels: ['Minor', 'Major', 'Critical'],
                datasets: [{
                    data: [
                        {{ $bugsBySeverity['minor'] ?? 0 }},
                        {{ $bugsBySeverity['major'] ?? 0 }},
                        {{ $bugsBySeverity['critical'] ?? 0 }}
                    ],
                    backgroundColor: ['#0dcaf0', '#ffc107', '#dc3545'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Bugs per Project - Horizontal Bar
        new Chart(document.getElementById('projectChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($projectBugCounts->pluck('name')) !!},
                datasets: [{
                    label: 'Bugs',
                    data: {!! json_encode($projectBugCounts->pluck('bugs_count')) !!},
                    backgroundColor: '#0d6efd',
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endpush
