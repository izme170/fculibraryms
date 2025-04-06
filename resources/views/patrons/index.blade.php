@extends('layout.main')
@extends('modals.patron.import')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    @include('include.patron_tabs')
    <div class="bg-white rounded p-3" style="min-width: fit-content">
        <div class="d-flex flex-row flex-wrap justify-content-between gap-2">
            <div>
                <a class="btn-simple" href="{{ route('patrons.import') }}">Add Patron</a>
                <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#importPatrons">Import</button>
                <a class="btn-simple" href="/patrons/export">Export</a>
            </div>
            <div class="d-flex gap-3">
                <div class="d-flex flex-column justify-content-between align-items-end">
                    <!-- Patrons search -->
                    <form method="GET" action="/patrons" class="d-flex flex-row align-items-center gap-2" id="filterForm">
                        <input type="text" name="search" class="form-control" placeholder="Search patron..."
                            value="{{ $search }}">
                    </form>
                </div>
                <div class="dropdown">
                    <button class="btn text-white dropdown-toggle" style="background-color: #0E1133" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Sort
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item"
                                href="?sort=first_name&direction={{ $direction === 'asc' && $sort === 'first_name' ? 'desc' : 'asc' }}">
                                Name
                                @if ($sort === 'first_name')
                                    <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="d-flex">
            <div class="dropdown">
                <button class="btn text-secondary dropdown-toggle border-0" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Course
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="?course_filter=">All</a>
                        @foreach ($courses as $course)
                            <a class="dropdown-item" href="?course_filter={{ $course->course_id }}">
                                {{ $course->course }}
                            </a>
                        @endforeach
                    </li>
                </ul>
            </div>
            <div class="dropdown">
                <button class="btn text-secondary dropdown-toggle border-0" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Department
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="?department_filter=">All</a>
                        @foreach ($departments as $department)
                            <a class="dropdown-item" href="?department_filter={{ $department->department_id }}">
                                {{ $department->department }}
                            </a>
                        @endforeach
                    </li>
                </ul>
            </div>
            <div class="dropdown">
                <button class="btn text-secondary dropdown-toggle border-0" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Patron Type
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="?type_filter=">All</a>
                        @foreach ($types as $type)
                            <a class="dropdown-item" href="?type_filter={{ $type->type_id }}">
                                {{ $type->type }}
                            </a>
                        @endforeach
                    </li>
                </ul>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-3 mt-3 justify-content-center">
            @foreach ($patrons as $patron)
                <a class="card text-decoration-none" href="/patron/show/{{ $patron->patron_id }}"
                    data-status="{{ $patron->status }}">
                    <img class="img"
                        src="{{ $patron->patron_image ? asset('storage/' . $patron->patron_image) : asset('img/default-patron-image.png') }}"
                        alt="Patron Image">
                    <div class="text">
                        <p class="h3">{{ $patron->first_name }} {{ $patron->last_name }}</p>
                        <p class="p">{{ $patron->type->type }}</p>
                        <p class="p">{{ $patron->department_acronym ?? '' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $patrons->links() }}
        </div>
    </div>
@endsection
