@extends('layout.main')
@include('include.sidenav')
@section('user-content')
@include('include.topbar')
<div class="widget">
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
                    <div class="mb-3">
                        <label class="form-label" for="due">Due</label>
                        <select id="due" name="due">
                            <option value="oneHour" selected>1 Hour</option>
                            <option value="oneDay">1 Day</option>
                        </select>
                    </div>
                </div>
            </div>
            <button class="btn-simple btn-right" type="submit">Submit</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('keydown', function(event){
        if(event.key === 'Enter')
        event.preventDefault();
    });
</script>
@endsection
