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
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Book</th>
                    <th scope="col">Patron</th>
                    <th scope="col">Librarian on Duty</th>
                    <th scope="col">Fine</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrowed_books as $borrowed_book)
                    <tr onclick="window.location.href='/borrowed_book/show/{{ $borrowed_book->borrow_id }}';"
                        style="cursor:pointer;">
                        <td>{{ $borrowed_book->created_at->format('m/d/y h:i a') }}</td>
                        <td>{{ $borrowed_book->title }}</td>
                        <td>{{ $borrowed_book->patron_first_name }} {{ $borrowed_book->patron_last_name }}</td>
                        <td>{{ $borrowed_book->user_first_name }} {{ $borrowed_book->user_last_name }}</td>
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
    </div>
@endsection
