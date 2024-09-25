@extends('layout.main')
@include('include.sidenav')
@section('user-content')
@include('include.messages')
<div class="form-container">
    <form action="/borrow-book/process" method="post">
        @csrf
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label class="form-label" for="library_id">Patron RFID</label>
                    <input type="text" id="library_id" name="library_id" autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="book_number">Book RFID</label>
                    <input type="text" id="book_number" name="book_number">
                </div>
            </div>
        </div>
        <button class="btn-simple btn-right" type="submit">Submit</button>
    </form>
</div>

<script>
    document.addEventListener('keydown', function(event){
        if(event.key === 'Enter')
        event.preventDefault();
    });
</script>
@endsection
