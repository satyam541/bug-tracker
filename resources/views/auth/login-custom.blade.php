@extends('layouts.auth')
@section('title', 'Login')

@section('content')
    <div class="brand">
        <h2><i class="bi bi-bug"></i> Bug Tracker</h2>
        <p>Sign in to your account</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger py-2">
            @foreach ($errors->all() as $error)
                <small>{{ $error }}</small><br>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                    required autofocus placeholder="you@example.com">
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" required
                    placeholder="Enter password">
            </div>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
        </button>

        <div class="text-center mt-3">
            <small>Don't have an account? <a href="{{ route('register') }}">Register</a></small>
        </div>
    </form>
@endsection
