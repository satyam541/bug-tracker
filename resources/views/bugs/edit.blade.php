@extends('layouts.app')
@section('title', 'Edit Bug')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white"><strong>Edit Bug #{{ $bug->id }}:
                        {{ Str::limit($bug->title, 40) }}</strong></div>
                <div class="card-body">
                    <form action="{{ route('bugs.update', $bug) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Bug Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $bug->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                rows="5" required>{{ old('description', $bug->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="project_id" class="form-label">Project <span
                                        class="text-danger">*</span></label>
                                <select name="project_id" id="project_id"
                                    class="form-select @error('project_id') is-invalid @enderror" required>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"
                                            {{ old('project_id', $bug->project_id) == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}</option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="assigned_to" class="form-label">Assign To</label>
                                <select name="assigned_to" id="assigned_to"
                                    class="form-select @error('assigned_to') is-invalid @enderror">
                                    <option value="">Unassigned</option>
                                    @foreach ($developers as $dev)
                                        <option value="{{ $dev->id }}"
                                            {{ old('assigned_to', $bug->assigned_to) == $dev->id ? 'selected' : '' }}>
                                            {{ $dev->name }}</option>
                                    @endforeach
                                </select>
                                @error('assigned_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status"
                                    class="form-select @error('status') is-invalid @enderror" required>
                                    @foreach (['open', 'in_progress', 'fixed', 'closed'] as $s)
                                        <option value="{{ $s }}"
                                            {{ old('status', $bug->status) == $s ? 'selected' : '' }}>
                                            {{ str_replace('_', ' ', ucfirst($s)) }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                <select name="priority" id="priority"
                                    class="form-select @error('priority') is-invalid @enderror" required>
                                    @foreach (['low', 'medium', 'high', 'critical'] as $p)
                                        <option value="{{ $p }}"
                                            {{ old('priority', $bug->priority) == $p ? 'selected' : '' }}>
                                            {{ ucfirst($p) }}</option>
                                    @endforeach
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="severity" class="form-label">Severity <span class="text-danger">*</span></label>
                                <select name="severity" id="severity"
                                    class="form-select @error('severity') is-invalid @enderror" required>
                                    @foreach (['minor', 'major', 'critical'] as $sv)
                                        <option value="{{ $sv }}"
                                            {{ old('severity', $bug->severity) == $sv ? 'selected' : '' }}>
                                            {{ ucfirst($sv) }}</option>
                                    @endforeach
                                </select>
                                @error('severity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="screenshot" class="form-label">Screenshot</label>
                                <input type="file" name="screenshot" id="screenshot"
                                    class="form-control @error('screenshot') is-invalid @enderror" accept="image/*">
                                @error('screenshot')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if ($bug->screenshot)
                            <div class="mb-3">
                                <label class="form-label">Current Screenshot</label><br>
                                <img src="{{ asset('storage/' . $bug->screenshot) }}" alt="Bug Screenshot"
                                    class="img-thumbnail" style="max-height: 200px;">
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="remove_screenshot" class="form-check-input"
                                        id="removeScreenshot" value="1">
                                    <label class="form-check-label" for="removeScreenshot">Remove current screenshot</label>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Update
                                Bug</button>
                            <a href="{{ route('bugs.show', $bug) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
