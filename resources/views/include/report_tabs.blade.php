<ul class="nav nav-tabs">
    <li class="nav-item rounded-top">
        <a class="nav-link {{ request()->is('reports') ? 'active' : 'text-black' }}" aria-current="page" href="/reports">Top Users</a>
    </li>
    <li class="nav-item rounded-top">
        <a class="nav-link {{ request()->is('reports/login-statistics') ? 'active' : 'text-black' }}" href="{{ route('reports.loginStatistics') }}">Daily Login Statistics</a>
    </li>
    <li class="nav-item rounded-top">
        <a class="nav-link {{ request()->is('reports/monthly-login-statistics') ? 'active' : 'text-black' }}" href="{{ route('reports.monthly_login_statistics') }}">Monthly Login Statistics</a>
    </li>
    <li class="nav-item rounded-top">
        <a class="nav-link {{ request()->is('reports/unreturned-materials') ? 'active' : 'text-black' }}" href="{{ route('reports.unreturnedMaterials') }}">Unreturned Materials</a>
    </li>
</ul>