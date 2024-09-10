@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <h1>{{ $user->first_name . ' ' . $user->last_name }}</h1>
    <p>{{ $user->role }}</p>
    <p>Contact Number: {{ $user->contact_number }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>username: {{ $user->username }}</p>

    <a class="btn-simple" href="/user/edit/{{ $user->user_id }}">Update</a>
    <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#archiveUser">Archive</button>
    <a class="btn-simple" href="/user/change-password/{{ $user->user_id }}">Change Password</a>

    <div class="modal fade" id="archiveUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Archive User?</h1>
                </div>
                <div class="modal-body">
                    <form action="/user/archive/{{$user->user_id}}" method="post">
                        @csrf
                        @method('PUT')
                        <p>Are you sure you want to archive {{ $user->first_name . ' ' . $user->last_name }}' account?</p>
                        <button class="btn-simple" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button class="btn-simple" type="submit">Archive</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
