<ul class="nav nav-tabs">
    <li class="nav-item rounded-top">
        <a class="nav-link {{ request()->is('users') ? 'active' : 'text-black' }}" href="{{ route('users.index') }}">Users</a>
    </li>
    <li class="nav-item rounded-top">
        <a class="nav-link {{ request()->is('roles') ? 'active' : 'text-black' }}" href="{{ route('users.roles') }}">Roles</a>
    </li>
    <li class="nav-item rounded-top">
        <a class="nav-link {{ request()->is('users/archives') ? 'active' : 'text-black' }}" href="{{ route('users.archives') }}">Archives</a>
    </li>
</ul>