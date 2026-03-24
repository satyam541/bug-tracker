@extends('layouts.auth')
@section('title', 'Register')

@section('content')
    <div class="brand">
        <h2><i class="bi bi-bug"></i> Bug Tracker</h2>
        <p>Create a new account</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger py-2">
            @foreach ($errors->all() as $error)
                <small>{{ $error }}</small><br>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                    required autofocus placeholder="John Doe">
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                    required placeholder="you@example.com">
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" required
                    placeholder="Min 8 characters">
            </div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required
                    placeholder="Repeat password">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="bi bi-person-plus me-1"></i> Register
        </button>

        <div class="text-center mt-3">
            <small>Already have an account? <a href="{{ route('login') }}">Sign In</a></small>
        </div>
    </form>
@endsection
