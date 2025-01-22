@extends('layout.main')
@include('include.sidenav')
@section('user-content')
<div class="widget">
    <div class="form-container">
        <form action="/return-book/process" method="post">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                    <h1>Please scan the book's RFID</h1>
                        <!-- <label class="form-label" for="book_number">Please scan the book's RFID</label> -->
                        <input type="text" id="book_number" name="book_number" autofocus>
                    </div>
                </div>
            </div>
            <!-- <button class="btn-simple btn-right" type="submit">Submit</button> -->
        </form>
    </div>
</div>
@endsection
