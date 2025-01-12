@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <ul class="nav nav-tabs">
        <li class="nav-item bg-secondary rounded-top">
            <a class="nav-link text-black" aria-current="page" href="/books">Books</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="/borrowed-books">Borrowed Books</a>
        </li>
    </ul>
    <div class="bg-white p-3" style="min-width: fit-content">
        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
            <form method="GET" action="/borrowed-books" id="filterForm" class="m-0">
                <input type="text" name="search" class="form-control" placeholder="Search..."
                    value="{{ $search }}">
            </form>

            <div class="d-flex flex-row align-items-center gap-2">
                <a href="javascript:void(0);" class="legend-btn {{ $status === 'all' ? 'active' : '' }}"
                    data-status="all">All</a>
                <a href="javascript:void(0);" class="legend-btn {{ $status === 'returned' ? 'active' : '' }}"
                    data-status="returned">Returned</a>
                <a href="javascript:void(0);" class="legend-btn {{ $status === 'borrowed' ? 'active' : '' }}"
                    data-status="borrowed">Borrowed</a>
                <a href="javascript:void(0);" class="legend-btn {{ $status === 'overdue' ? 'active' : '' }}"
                    data-status="overdue">Overdue</a>
            </div>
        </div>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">
                        <a href="?sort=created_at&direction={{ $direction === 'asc' ? 'desc' : 'asc' }}"
                            class="text-decoration-none text-white d-block">
                            Date
                            @if ($sort === 'created_at')
                                <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        <a href="?sort=title&direction={{ $direction === 'asc' ? 'desc' : 'asc' }}"
                            class="text-decoration-none text-white d-block">
                            Book
                            @if ($sort === 'title')
                                <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        <a href="?sort=patrons_name&direction={{ $direction === 'asc' ? 'desc' : 'asc' }}"
                            class="text-decoration-none text-white d-block">
                            Patron
                            @if ($sort === 'patrons_name')
                                <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        <a href="?sort=users_name&direction={{ $direction === 'asc' ? 'desc' : 'asc' }}"
                            class="text-decoration-none text-white d-block">
                            Librarian on Duty
                            @if ($sort === 'users_name')
                                <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        <a href="?sort=fine&direction={{ $direction === 'asc' ? 'desc' : 'asc' }}"
                            class="text-decoration-none text-white d-block">
                            Fine
                            @if ($sort === 'fine')
                                <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrowed_books as $borrowed_book)
                    <tr onclick="window.location.href='/borrowed_book/show/{{ $borrowed_book->borrow_id }}';"
                        style="cursor:pointer;">
                        <td>{{ $borrowed_book->created_at->format('m/d/y h:i a') }}</td>
                        <td>{{ $borrowed_book->book->title }}</td>
                        <td>{{ $borrowed_book->patron->first_name }} {{ $borrowed_book->patron->last_name }}</td>
                        <td>{{ $borrowed_book->user->first_name }} {{ $borrowed_book->user->last_name }}</td>
                        <td>₱{{ $borrowed_book->fine }}</td>
                        <td>
                            <span
                                class="badge
                                    {{ $borrowed_book->returned ? 'bg-success' : 'bg-warning' }}">
                                {{ $borrowed_book->returned ? 'Returned' : 'Not Returned' }}
                            </span>
                            @if ($borrowed_book->fine)
                                <span class="badge bg-danger">Overdue</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 d-flex justify-content-center">
            {{ $borrowed_books->links() }}
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
