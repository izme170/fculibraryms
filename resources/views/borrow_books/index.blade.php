@extends('layout.main')
@include('include.sidenav_admin')
@section('user-content')
<a class="btn-simple" href="/borrow-book">Borrow Book</a>
<a class="btn-simple" href="/return-book">Return Book</a>
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
            <tr onclick="window.location.href='/admin/borrowed_book/show/{{$borrowed_book->borrow_id}}';" style="cursor:pointer;">
                <td>{{$borrowed_book->created_at}}</td>
                <td>{{$borrowed_book->title}}</td>
                <td>{{$borrowed_book->patron_first_name}} {{$borrowed_book->patron_last_name}}</td>
                <td>{{$borrowed_book->user_first_name}} {{$borrowed_book->user_last_name}}</td>
                <td>{{is_null($borrowed_book->returned) ? 'Not returned' : $borrowed_book->returned }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection