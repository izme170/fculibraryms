@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/books">Books</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/borrowed-books">Borrowed Books</a>
        </li>
    </ul>
    <div class="mt-3">
        <a class="btn-simple" href="/book/create">Add book</a>
        <a class="btn-simple" href="/borrow-book">Borrow Book</a>
        <a class="btn-simple" href="/return-book">Return Book</a>
    </div>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Book Number</th>
                <th scope="col">Title</th>
                <th scope="col">Author</th>
                <th scope="col">Category</th>
                <th scope="col">Available</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr onclick="window.location.href='/book/show/{{ $book->book_id }}';" style="cursor:pointer;">
                    <td>{{ $book->book_number }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->category }}</td>
                    <td>{{ $book->is_available }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
