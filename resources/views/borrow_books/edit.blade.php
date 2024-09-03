@extends('layout.main')
@include('include.sidenav_admin')
@section('user-content')
@include('include.messages')
<div class="form-container">
    <form action="/return-book/process" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label class="form-label" for="book_number">Book Number</label>
                    <input type="text" id="book_number" name="book_number">
                </div>
            </div>
        </div>
        <button class="btn-simple btn-right" type="submit">Submit</button>
    </form>
</div>
@endsection