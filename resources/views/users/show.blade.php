@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <div class="bg-white p-3 rounded d-flex gap-3 flex-wrap justify-content-center" style="min-width: fit-content">
        <div>
            <img src="{{ asset('img/default-user-image.png') }}" class="img-thumbnail img-fluid" alt="..." width="200px">
        </div>
        <div>
            <h1>{{ $user->first_name . ' ' . $user->last_name }}</h1>
            <p>{{ $user->role->role }}</p>
            <p>Contact Number: {{ $user->contact_number }}</p>
            <p>Email: {{ $user->email }}</p>
            <p>username: {{ $user->username }}</p>
            <div class="mb-3">
                <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#editUser">Update</button>
                <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#archiveUser">Archive</button>
            </div>
        </div>
    </div>
    @include('modals.user.edit')
    @include('modals.user.archive')

    @include('include.messages')
@endsection
