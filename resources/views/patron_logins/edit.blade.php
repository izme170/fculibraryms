@extends('layout.main')
@section('patron-content')
<div class="container">
    <h1>RFID Logout</h1>
    <form action="/patrons/logout/update" method="post">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <label for="library_id">RFID</label>
            <input type="text" id="library_id" name="library_id" autofocus>
        </div>
    </form>
</div>
@include('include.messages')
@endsection