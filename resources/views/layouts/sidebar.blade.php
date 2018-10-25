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
            <li class="nav-item {{ Request::is('indicators*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("indicators.index") }}">
                    <span data-feather="info"></span>
                    {{ __("messages.indicators") }}
                </a>
            </li>
            <li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("users.index") }}">
                    <span data-feather="users"></span>
                    {{ __("messages.users") }}
                </a>
            </li>
            @if(Auth::user()->role->slug == "admin")
                <li class="nav-item {{ Request::is('roles*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route("roles.index") }}">
                        <span data-feather="user-check"></span>
                        {{ __("messages.roles") }}
                    </a>
                </li>
            @endif
            <li class="nav-item {{ Request::is('settings*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("settings") }}">
                    <span data-feather="settings"></span>
                    {{ __("messages.settings") }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("logout") }}">
                    <span data-feather="log-out"></span>
                    {{ __("messages.logout") }}
                </a>
            </li>
        </ul>
    </div>
</nav>