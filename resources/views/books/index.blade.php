@extends('layout.main')
@include('include.sidenav_admin')
@section('user-content')
<a class="btn-simple" href="/admin/book/create">Add book</a>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Book Number</th>
            <th scope="col">Name</th>
            <th scope="col">Author</th>
            <th scope="col">Category</th>
            <th scope="col">Qty</th>
            <th scope="col">Available</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($books as $book)
            <tr onclick="window.location.href='/admin/book/show/{{$book->book_id}}';" style="cursor:pointer;">
                <td>{{$book->book_number}}</td>
                <td>{{$book->name}}</td>
                <td>{{$book->author}}</td>
                <td>{{$book->category_id}}</td>
                <td>{{$book->qty}}</td>
                <td>{{$book->available}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection