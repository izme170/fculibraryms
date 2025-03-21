@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    <div class="widget">
        <a href="{{ route('materials.index') }}" class="text-decoration-none text-dark">
            <x-lucide-arrow-left width="30" class="mb-2" />
        </a>
        <div class="form-container">
            <form action="/return-material/process" method="post">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <h1>Please scan the material's RFID</h1>
                            <!-- <label class="form-label" for="rfid">Please scan the material's RFID</label> -->
                            <input type="text" id="rfid" name="rfid" autofocus>
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
