@extends('layout.main')
@section('patron-content')
<div class="container">
    <form id="rfid_form">
        @csrf
        <div class="mb-3">
            <h1>Patron Logout</h1>
            <label for="rfid_input">Please, scan your RFID to Logout</label>
            <input type="text" id="rfid_input" name="library_id" placeholder="Scan RFID to Logout">
            <h1 id="message"></h1>
        </div>
    </form>
    @include('include.messages')
</div>

<script>
    const rfid_form = document.getElementById("rfid_form");
    const rfid_input = document.getElementById("rfid_input");
    const message = document.getElementById("message");

    document.addEventListener("keypress", function(event) {
        if (event.key !== "Enter") {
            rfid_input.value += event.key; // Append the key to the input
        } else {
            event.preventDefault(); // Prevent default form submission

            let rfid = rfid_input.value.trim(); // Get the RFID value

            if (rfid !== "") {
                // Send the RFID via AJAX
                fetch('/patrons/logout/process', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token
                    },
                    body: JSON.stringify({ library_id: rfid })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        message.textContent = data.message_success; // Update message on success
                        setTimeout(() => {
                            location.reload(); // Reload after 10 seconds
                        }, 10000);
                    } else {
                        message.textContent = data.message_error; // Update message on error
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    message.textContent = 'An error occurred. Please try again.'; // Handle errors
                });

                rfid_input.value = ""; // Clear the RFID input after submission
            }
        }
    });
</script>
@endsection
