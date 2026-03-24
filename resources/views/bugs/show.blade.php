@extends('layouts.app')
@section('title', 'Bug #' . $bug->id)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Bug #{{ $bug->id }}: {{ $bug->title }}</h4>
        <div class="d-flex gap-2">
            @if (auth()->user()->hasRole('admin', 'developer'))
                <a href="{{ route('bugs.edit', $bug) }}" class="btn btn-outline-primary btn-sm"><i
                        class="bi bi-pencil me-1"></i> Edit</a>
            @endif
            <a href="{{ route('bugs.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>
                Back</a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Bug Detail -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white"><strong>Description</strong></div>
                <div class="card-body">
                    <p class="mb-0">{!! nl2br(e($bug->description)) !!}</p>
                </div>
            </div>

            @if ($bug->screenshot)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white"><strong>Screenshot</strong></div>
                    <div class="card-body text-center">
                        <a href="{{ asset('storage/' . $bug->screenshot) }}" target="_blank">
                            <img src="{{ asset('storage/' . $bug->screenshot) }}" alt="Bug Screenshot"
                                class="img-fluid rounded" style="max-height: 400px;">
                        </a>
                        <div class="mt-2 text-muted small">Click image to view full size</div>
                    </div>
                </div>
            @endif

            <!-- Comments Section -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white"><strong>Comments ({{ $bug->comments->count() }})</strong></div>
                <div class="card-body">
                    @forelse($bug->comments as $comment)
                        <div class="d-flex mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px; font-size: 16px;">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0 mt-1">{!! nl2br(e($comment->body)) !!}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No comments yet. Be the first to comment!</p>
                    @endforelse

                    <hr>
                    <form action="{{ route('comments.store', $bug) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="body" class="form-label">Add Comment</label>
                            <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" rows="3"
                                placeholder="Write your comment..." required>{{ old('body') }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-chat-dots me-1"></i> Post
                            Comment</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white"><strong>Bug Details</strong></div>
                <div class="card-body">
                    <table class="table table-borderless table-sm mb-0">
                        <tr>
                            <td class="text-muted fw-semibold">Status</td>
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
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Priority</td>
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
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Severity</td>
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
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Project</td>
                            <td><a href="{{ route('projects.show', $bug->project) }}">{{ $bug->project->name }}</a></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Reported By</td>
                            <td>{{ $bug->reporter->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Assigned To</td>
                            <td>{{ $bug->assignee->name ?? 'Unassigned' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Created</td>
                            <td>{{ $bug->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Updated</td>
                            <td>{{ $bug->updated_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
