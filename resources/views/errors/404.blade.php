@extends('layouts.app')
@section('title', 'Page Not Found')

@section('content')
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 50vh;">
        <h1 class="display-1 fw-bold text-muted">404</h1>
        <h4 class="mb-3">Page Not Found</h4>
        <p class="text-muted mb-4">The page you are looking for doesn't exist or has been moved.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="bi bi-house me-1"></i> Back to Dashboard</a>
    </div>
@endsection
