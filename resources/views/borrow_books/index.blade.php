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
    <div class="container">
        <table class="table">
            <thead class="thead-dark">
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
                        <td>{{ $borrowed_book->created_at->format('m/d/y h:i a')}}</td>
                        <td>{{ $borrowed_book->title }}</td>
                        <td>{{ $borrowed_book->patron_first_name }} {{ $borrowed_book->patron_last_name }}</td>
                        <td>{{ $borrowed_book->user_first_name }} {{ $borrowed_book->user_last_name }}</td>
                        <td>₱{{ $borrowed_book->fine }}</td>
                        <td>{{ $borrowed_book->returned ? 'Returned' : 'Not returned' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
