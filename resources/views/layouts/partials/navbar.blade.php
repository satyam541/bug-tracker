<div class="top-navbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-link text-dark d-lg-none p-0" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>
        <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span
            class="badge bg-{{ auth()->user()->isAdmin() ? 'danger' : (auth()->user()->isDeveloper() ? 'primary' : 'success') }}">
            {{ ucfirst(auth()->user()->role->name ?? 'User') }}
        </span>
        <span class="text-muted">{{ auth()->user()->name }}</span>
    </div>
</div>
