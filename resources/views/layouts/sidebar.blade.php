<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("userList") }}">
                    <span data-feather="users"></span>
                    Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ Sentinel::logout() }}">
                    <span data-feather="log-out"></span>
                    Log-out
                </a>
            </li>
        </ul>
    </div>
</nav>