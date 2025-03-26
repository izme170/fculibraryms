<ul class="nav nav-tabs">
    <li class="nav-item rounded-top">
        <a class="nav-link {{ request()->is('materials') ? 'active' : 'text-black' }}" href="{{ route('materials.index') }}">Materials</a>
    </li>
    <li class="nav-item rounded-top">
        <a class="nav-link {{ request()->is('material-copies') ? 'active' : 'text-black' }}" href="{{ route('material-copies.index') }}">Copies</a>
    </li>
    <li class="nav-item rounded-top">
        <a class="nav-link {{ request()->is('borrowed-materials') ? 'active' : 'text-black' }}" href="{{ route('borrowed-materials.index') }}">Borrowed Materials</a>
    </li>
    <li class="nav-item rounded-top">
        <a class="nav-link {{ request()->is('materials/archives') ? 'active' : 'text-black' }}" href="{{ route('materials.archives') }}">Archived Materials</a>
    </li>
    <li class="nav-item rounded-top">
        <a class="nav-link {{ request()->is('material-copies/archives') ? 'active' : 'text-black' }}" href="{{ route('material-copies.archives') }}">Archived Copies</a>
    </li>
</ul>
