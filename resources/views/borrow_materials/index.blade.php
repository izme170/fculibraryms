@extends('layout.main')
@extends('modals.filter_date')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    @include('include.material_tabs')
    <div class="bg-white p-3" style="min-width: fit-content">
        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
            <div>
                <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#filterDate">Filter
                    Date</button>
                <a class="btn-simple" href="{{ route('borrowed-materials.export', request()->query()) }}">Export</a>
            </div>

            <form method="GET" action="/borrowed-materials" id="filterForm" class="m-0">
                <input type="text" name="search" placeholder="Search..."
                    value="{{ $search }}">
            </form>

            <div class="d-flex flex-row align-items-center gap-2">
                <a href="?status=all" class="legend-btn {{ $status === 'all' ? 'active' : '' }}">All</a>
                <a href="?status=returned" class="legend-btn {{ $status === 'returned' ? 'active' : '' }}">Returned</a>
                <a href="?status=borrowed" class="legend-btn {{ $status === 'borrowed' ? 'active' : '' }}">Borrowed</a>
                <a href="?status=overdue" class="legend-btn {{ $status === 'overdue' ? 'active' : '' }}">Overdue</a>
            </div>

            <a href="{{ route('borrowed-materials.index') }}" type="submit" class="btn">Show All</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">
                        <a href="?sort=created_at&direction={{ $direction === 'asc' ? 'desc' : 'asc' }}"
                            class="text-decoration-none text-black d-block">
                            Date
                            @if ($sort === 'created_at')
                                <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        <a href="?sort=title&direction={{ $direction === 'asc' ? 'desc' : 'asc' }}"
                            class="text-decoration-none text-black d-block">
                            Material
                            @if ($sort === 'title')
                                <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        <a href="?sort=patrons_name&direction={{ $direction === 'asc' ? 'desc' : 'asc' }}"
                            class="text-decoration-none text-black d-block">
                            Patron
                            @if ($sort === 'patrons_name')
                                <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        <a href="?sort=users_name&direction={{ $direction === 'asc' ? 'desc' : 'asc' }}"
                            class="text-decoration-none text-black d-block">
                            Librarian on Duty
                            @if ($sort === 'users_name')
                                <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        <a href="?sort=fine&direction={{ $direction === 'asc' ? 'desc' : 'asc' }}"
                            class="text-decoration-none text-black d-block">
                            Fine
                            @if ($sort === 'fine')
                                <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        Status
                    </th>
                    <th scope="col">
                        Before
                    </th>
                    <th scope="col">
                        After
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrowed_materials as $borrowed_material)
                    <tr onclick="window.location.href='/borrowed-material/show/{{ $borrowed_material->borrow_id }}';"
                        style="cursor:pointer;">
                        <td>{{ $borrowed_material->created_at->format('m/d/y h:i a') }}</td>
                        <td>{{ $borrowed_material->materialCopy->material->title }}</td>
                        <td>{{ $borrowed_material->patron->first_name }} {{ $borrowed_material->patron->last_name }}</td>
                        <td>{{ $borrowed_material->user->first_name }} {{ $borrowed_material->user->last_name }}</td>
                        <td>₱{{ $borrowed_material->fine }}</td>
                        <td class="d-flex gap-1">
                            <span
                                class="badge
                                    {{ $borrowed_material->returned ? 'bg-success' : 'bg-warning' }}">
                                {{ $borrowed_material->returned ? 'Returned' : 'Checked Out' }}
                            </span>
                            @if ($borrowed_material->fine)
                                <span class="badge bg-danger">Overdue</span>
                            @endif
                        </td>
                        <td>{{ $borrowed_material->conditionBefore->name ?? 'Not Specified' }}</td>
                        <td>{{ $borrowed_material->returned ? $borrowed_material->conditionAfter->name ?? 'Not specified' : 'Pending' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 d-flex justify-content-center">
            {{ $borrowed_materials->links() }}
        </div>
    </div>
    <script>
        // Get all legend buttons
        const legendButtons = document.querySelectorAll('.legend-btn');

        // Add event listener to each button
        legendButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get the status from the data-status attribute
                const status = this.getAttribute('data-status');

                // Remove 'active' class from all buttons
                legendButtons.forEach(btn => btn.classList.remove('active'));

                // Add 'active' class to the clicked button
                this.classList.add('active');

                // Update the status in the form and submit it
                const form = document.getElementById('filterForm');
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = status;

                // Append the status input to the form and submit the form
                form.appendChild(statusInput);
                form.submit();
            });
        });
    </script>
@endsection
