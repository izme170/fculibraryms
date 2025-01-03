@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/books">Books</a>
        </li>
        <li class="nav-item bg-secondary rounded-top">
            <a class="nav-link text-black" href="/borrowed-books">Borrowed Books</a>
        </li>
    </ul>
    <div class="container">
        <div class="mt-3 d-flex flex-row justify-content-between">
            <div>
                <a class="btn-simple" href="/book/create">Add book</a>
                <a class="btn-simple" href="/borrow-book">Borrow Book</a>
                <a class="btn-simple" href="/return-book">Return Book</a>
                <a class="btn-simple" href="/books/export">Export</a>
            </div>
            <div>
                <div class="d-flex flex-column justify-content-between align-items-end mb-3">
                    <!-- Form to filter books -->
                    <form method="GET" action="/books" class="d-flex flex-row align-items-center gap-2" id="filterForm">
                        <input type="text" name="search" class="form-control" placeholder="Search by title or author"
                            value="{{ $search }}">

                        <!-- Category filter -->
                        <select name="category" class="form-select">
                            <option value="all" {{ $category === 'all' ? 'selected' : '' }}>All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->category_id }}"
                                    {{ $category == $cat->category_id ? 'selected' : '' }}>
                                    {{ $cat->category }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <!-- Status filter/legend -->
                    <div class="d-flex flex-row align-items-center gap-2">
                        <a href="javascript:void(0);" class="legend-btn {{ $status === 'all' ? 'active' : '' }}"
                            data-status="all">All</a>
                        <a href="javascript:void(0);" class="legend-btn {{ $status === 'available' ? 'active' : '' }}"
                            data-status="available">Available</a>
                        <a href="javascript:void(0);" class="legend-btn {{ $status === 'borrowed' ? 'active' : '' }}"
                            data-status="borrowed">Borrowed</a>
                        <a href="javascript:void(0);" class="legend-btn {{ $status === 'overdue' ? 'active' : '' }}"
                            data-status="overdue">Overdue</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-3 mt-3 justify-content-center">
            @foreach ($books as $book)
                <a class="card text-decoration-none" href="/book/show/{{ $book->book_id }}"
                    data-status="{{ $book->status }}">
                    <div class="indicator-container">
                        <div class="status-indicator {{ $book->status }}"></div>
                    </div>
                    <div class="img" style="background-image: url('{{ asset('img/default-book-cover.png') }}');">
                    </div>
                    <div class="text">
                        <p class="h3">{{ $book->title }}</p>
                        <p class="p">{{ $book->author }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- pagination --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $books->appends(['status' => $status, 'category' => $category, 'search' => $search])->links() }}
        </div>
    </div>
    <script>
        // Get the category dropdown element
        const categorySelect = document.querySelector('select[name="category"]');

        // Attach a change event listener to the category dropdown
        categorySelect.addEventListener('change', function() {
            // Get the form by its ID and submit it
            document.getElementById('filterForm').submit();
        });

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
