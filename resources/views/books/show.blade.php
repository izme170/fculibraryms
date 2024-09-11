@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <h1>{{$book->title}}</h1>
    <p>{{$book->author}}</p>
    <p>Contact Number: {{ $user->contact_number }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>username: {{ $user->username }}</p>

    <div class="mb-3">
        <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#editUser">Update</button>
        <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#archiveUser">Archive</button>
        <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#changeUserPassword">Change
            Password</button>
    </div>
    @include('modals.user.edit')
    @include('modals.user.archive')
    @include('modals.user.change_password')

    @include('include.messages')
@endsection
