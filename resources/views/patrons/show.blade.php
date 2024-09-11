@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <h1>{{ $patron->first_name }} {{ $patron->last_name }}</h1>
    <p>{{ $patron->type }}</p>
    <p>{{ $patron->library_id }}</p>
    <p>Contact Number: {{ $patron->contact_number }}</p>
    <p>Email: {{ $patron->email }}</p>
    <p>Address: {{ $patron->address }}</p>
    <p>Department: {{ $patron->department }}</p>
    <p>Course: {{ $patron->course }}</p>
    <p>Adviser: {{ $patron->adviser }}</p>

    <div class="mb-3">
        <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#editPatron">Update</button>
        <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#archivePatron">Archive</button>
        <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#newPatronRFID">Assign new
            RFID</button>
    </div>
    @include('modals.patron.edit')
    @include('modals.patron.archive')
    @include('modals.patron.new_rfid')

    @include('include.messages')
@endsection
