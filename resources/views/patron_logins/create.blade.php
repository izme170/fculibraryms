@extends('layout.main')
@section('patron-content')
<div class="container">

    <form action="/patrons/login/store" method="post" id="rfid_form">
        @csrf
        <div class="mb-3">
            <input type="text" id="rfid_input" name="library_id">
        </div>
    </form>

    <form action="/patrons/login/update" method="post">
        @csrf
        <h1>Patron Login</h1>
        <div class="mb-3">
            @if(session('patron'))
                @php    $patron = session('patron'); @endphp
                <h1 id="message">Welcome, {{$patron->first_name}} {{$patron->last_name}}!</h1>
                <input type="text" id="patron_id" name="patron_id" value="{{$patron->patron_id}}" readonly hidden>
            @elseif (session()->has('message_success_xl'))
                <h1 id="message">{{ session('message_success_xl') }}</h1>

            @elseif (session()->has('message_error_xl'))
                <h1 id="message">{{ session('message_error_xl') }}</h1>
            @else
                <h1>Please Scan Your RFID</h1>
            @endif
        </div>
        <div class="mb-3">
            <label for="purpose_id">Purpose</label>
            <select id="purpose_id" name="purpose_id">
                <option value="">Select Purpose</option>
                @foreach ($purposes as $purpose)
                    <option value="{{ $purpose->purpose_id }}" {{$purpose->purpose_id == 1 ? 'selected' : ''}}>
                        {{ $purpose->purpose }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="marketer_id">Marketer</label>
            <select id="marketer_id" name="marketer_id">
                <option value="">Select Marketer</option>
                @foreach ($marketers as $marketer)
                    <option value="{{ $marketer->marketer_id }}">{{ $marketer->marketer }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-simple mb-3">Submit</button>
    </form>
</div>
<script>
    const rfid_form = document.getElementById("rfid_form");
    const rfid_input = document.getElementById("rfid_input");
    const message = document.getElementById("message")

    document.addEventListener("keypress", function (event) {
        if (event.key !== "Enter") {
            rfid_input.value += event.key;
        }
        rfid_form.submit();
    });

    if (message.textContent.trim() !== '') {
        setTimeout(function () {
            location.reload();
        }, 10000);
    }

</script>
@endsection