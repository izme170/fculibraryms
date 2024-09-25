@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="books-tab" data-bs-toggle="tab" data-bs-target="#books-tab-pane" type="button"
                role="tab" aria-controls="books-tab-pane" aria-selected="true">Books</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="borrowed-books-tab" data-bs-toggle="tab" data-bs-target="#borrowed-books-tab-pane"
                type="button" role="tab" aria-controls="borrowed-books-tab-pane" aria-selected="false">Borrowed
                Books</button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="books-tab-pane" role="tabpanel" aria-labelledby="books-tab"
            tabindex="0">
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
        </div>

        <div class="tab-pane fade" id="borrowed-books-tab-pane" role="tabpanel" aria-labelledby="borrowed-books-tab"
            tabindex="0">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Book</th>
                        <th scope="col">Patron</th>
                        <th scope="col">Librarian on Duty</th>
                        <th scope="col">Returned</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrowed_books as $borrowed_book)
                        <tr onclick="window.location.href='/borrowed_book/show/{{ $borrowed_book->borrow_id }}';"
                            style="cursor:pointer;">
                            <td>{{ $borrowed_book->created_at->format('F j, Y, g:i a') }}</td>
                            <td>{{ $borrowed_book->title }}</td>
                            <td>{{ $borrowed_book->patron_first_name }} {{ $borrowed_book->patron_last_name }}</td>
                            <td>{{ $borrowed_book->user_first_name }} {{ $borrowed_book->user_last_name }}</td>
                            <td>{{ $borrowed_book->returned ? $borrowed_book->returned->format('F j, Y, g:i a') : 'Not returned' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
