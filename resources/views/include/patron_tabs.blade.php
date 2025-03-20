<ul class="nav nav-tabs">
    <li class="nav-item rounded-top">
        <a class="nav-link {{ request()->is('patrons') ? 'active' : 'text-black' }}" href="{{ route('patrons.index') }}">Users</a>
    </li>
    <li class="nav-item rounded-top">
        <a class="nav-link {{ request()->is('patrons/archives') ? 'active' : 'text-black' }}" href="{{ route('patrons.archives') }}">Archives</a>
    </li>
</ul>