@extends('layout.main')
@section('patron-content')
<div class="container">
    <form action="/patrons/logout/process" method="post" id="rfid_form">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <input type="text" id="rfid_input" name="library_id">
            <h1>Patron Logout</h1>
            <label for="library_id">Please, scan your RFID to Logout</label>
        </div>
    </form>
    @include('include.messages')
</div>

<script>
    const rfid_form = document.getElementById("rfid_form");
    const rfid_input = document.getElementById("rfid_input");

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