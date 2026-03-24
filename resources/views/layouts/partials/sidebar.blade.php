<div class="sidebar">
    <div class="brand">
        <h4><i class="bi bi-bug"></i> Bug Tracker</h4>
        <small>Project Management</small>
    </div>

    <nav class="nav flex-column mt-2">
        <div class="sidebar-section">Main</div>

        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        @if (auth()->user()->isAdmin())
            <div class="sidebar-section">Administration</div>
            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                <i class="bi bi-people"></i> Users
            </a>
        @endif

        <div class="sidebar-section">Work</div>

        <a class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}" href="{{ route('projects.index') }}">
            <i class="bi bi-folder"></i> Projects
        </a>

        <a class="nav-link {{ request()->routeIs('bugs.*') ? 'active' : '' }}" href="{{ route('bugs.index') }}">
            <i class="bi bi-bug"></i> Bugs
        </a>

        <div class="sidebar-section">Account</div>

        <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
            <i class="bi bi-person-circle"></i> Profile
        </a>

        <a class="nav-link" href="#"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </nav>
</div>
