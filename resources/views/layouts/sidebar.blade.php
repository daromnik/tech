<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                    <span data-feather="home"></span>
                    {{ __("messages.dashboard") }}
                </a>
            </li>
            <li class="nav-item {{ Request::is('projects*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("projects.index") }}">
                    <span data-feather="briefcase"></span>
                    {{ __("messages.projects") }}
                </a>
            </li>

            <li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("userList") }}">
                    <span data-feather="users"></span>
                    {{ __("messages.users") }}
                </a>
            </li>
            @if(Sentinel::inRole("admin"))
                <li class="nav-item {{ Request::is('roles*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route("roleList") }}">
                        <span data-feather="user-check"></span>
                        {{ __("messages.roles") }}
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ route("logout") }}">
                    <span data-feather="log-out"></span>
                    {{ __("messages.logout") }}
                </a>
            </li>
        </ul>
    </div>
</nav>