@extends('layout.main')
@include('include.sidenav')
@section('user-content')
@include('include.topbar')
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
                        <div class="mb-3">
                            <h3>Remark</h3>
                            <div class="align-items-center">
                                @foreach ($remarks as $remark)
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="radio" id="{{ $remark->remark }}" name="remark_id"
                                            value="{{ $remark->remark_id }}" {{ $remark->remark_id == 1 ? 'checked' : '' }}>
                                        <label for="{{ $remark->remark }}">{{ $remark->remark }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn-simple" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter')
                event.preventDefault();
        });
    </script>
@endsection
