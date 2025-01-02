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
            <div class="d-flex flex-row align-items-center gap-2">
                <span class="legend-label">Available</span>
                <div class="status-indicator available"></div>

                <span class="legend-label">Borrowed</span>
                <div class="status-indicator borrowed"></div>

                <span class="legend-label">Overdue</span>
                <div class="status-indicator overdue"></div>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-3 mt-3 justify-content-center">
            @foreach ($books as $book)
                <a class="card text-decoration-none" href="/book/show/{{ $book->book_id }}">
                    <div class="indicator-container">
                        <div class="status-indicator {{ $book->status }}"></div>
                    </div>
                    <div class="img" style="background-image: url('{{ asset('img/default-book-cover.png') }}');">
                    </div>
                    <div class="text">
                        <p class="h3">{{ $book->title }}</p>
                        <p class="p">{{ $book->author }}</p>

                        {{-- <div class="icon-box">
                            <p class="span">View</p>
                        </div> --}}
                    </div>
                </a>
            @endforeach
        </div>
        {{-- <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Category</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr onclick="window.location.href='/book/show/{{ $book->book_id }}';" style="cursor:pointer;">
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->category }}</td>
                        <td>{{ $book->is_available? 'Available' : "Borrowed" }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
    </div>
@endsection
