@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    <div class="widget">
        <a href="{{ route('materials.index') }}" class="text-decoration-none text-dark">
            <x-lucide-arrow-left width="30" class="mb-3" />
        </a>
        <div class="form-container">
            <form action="/borrow-material/process" method="post">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="library_id">Patron RFID</label>
                            <input type="text" id="library_id" name="library_id" autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="rfid">Material RFID</label>
                            <input type="text" id="rfid" name="rfid">
                        </div>
                        <div class="mb-3">
                            <h3>Condition</h3>
                            <div class="align-items-center">
                                @foreach ($conditions as $condition)
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="radio" id="{{ $condition->name }}" name="condition_id"
                                            value="{{ $condition->condition_id }}">
                                        <label for="{{ $condition->name }}">{{ $condition->name }}</label>
                                    </div>
                                @endforeach
                            </div>
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
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter')
                event.preventDefault();
        });
    </script>
@endsection
