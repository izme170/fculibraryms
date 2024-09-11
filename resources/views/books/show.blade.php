@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <h1>{{$book->title}}</h1>
    <p>{{$book->author}}</p>
    <p>Category: {{ $book->category }}</p>
    <p>Quantity: {{ $book->qty }}</p>
    <p>Available: {{ $book->available }}</p>

    <div class="mb-3">
        <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#editBook">Update</button>
        <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#archiveBook">Archive</button>
        <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#newBookRFID">Assign new RFID</button>
    </div>
    @include('modals.book.edit')
    @include('modals.book.archive')
    @include('modals.book.new_rfid')

    @include('include.messages')
@endsection
