@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <!-- Profile Info -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white"><strong>Profile Information</strong></div>
                <div class="card-body">
                    <p class="text-muted small">Update your account's name and email address.</p>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Save
                            Changes</button>

                        @if (session('status') === 'profile-updated')
                            <span class="text-success ms-2"><i class="bi bi-check-circle"></i> Saved.</span>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Update Password -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white"><strong>Update Password</strong></div>
                <div class="card-body">
                    <p class="text-muted small">Ensure your account is using a long, random password to stay secure.</p>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" name="current_password" id="current_password"
                                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                required>
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password', 'updatePassword') is-invalid @enderror" required>
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="bi bi-lock me-1"></i> Update
                            Password</button>

                        @if (session('status') === 'password-updated')
                            <span class="text-success ms-2"><i class="bi bi-check-circle"></i> Saved.</span>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="card shadow-sm border-0 border-danger">
                <div class="card-header bg-white text-danger"><strong>Delete Account</strong></div>
                <div class="card-body">
                    <p class="text-muted small">Once your account is deleted, all data will be permanently removed.</p>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                        data-bs-target="#deleteAccountModal">
                        <i class="bi bi-trash me-1"></i> Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Account Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                        <div class="mb-3">
                            <label for="delete_password" class="form-label">Enter your password to confirm</label>
                            <input type="password" name="password" id="delete_password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror" required>
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete My Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
