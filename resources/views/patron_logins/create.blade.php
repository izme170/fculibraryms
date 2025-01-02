@extends('layout.main')
@section('patron-content')
    <div class="container">
        <input type="text" id="rfid_input" name="library_id" placeholder="Scan RFID here">
        <input type="hidden" id="patron_id" name="patron_id">
        <div>
            <h1>Patron Login</h1>
            <div class="mb-3">
                <h1 id="message">Please Scan Your RFID</h1>
            </div>
            <div id="patron_details" style="display:none;">
                <div class="mb-3">
                    <label for="purpose_id">Purpose</label>
                    <select id="purpose_id" name="purpose_id">
                        <option value="">Select Purpose</option>
                        @foreach ($purposes as $purpose)
                            <option value="{{ $purpose->purpose_id }}">{{ $purpose->purpose }}</option>
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
                <button id="submit_login" class="btn-simple mb-3">Submit</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rfid_input = document.getElementById("rfid_input");
            const message = document.getElementById("message");
            const patron_details = document.getElementById("patron_details");
            let reloadTimer;

            // Check if rfid sends a keyboard input
            document.addEventListener("keypress", function(event) {
                // Check if the event is not the Enter key
                if (event.key !== "Enter") {
                    // Append the key to the RFID input value
                    rfid_input.value += event.key;
                } else {
                    // If Enter is pressed
                    event.preventDefault(); // Prevent default form submission

                    let rfid = rfid_input.value.trim(); // Get the RFID value

                    //Check if the value is not Empty
                    if (rfid !== "") {
                        // Send the RFID via Fetch API
                        fetch("/patrons/login/store", {
                                method: "POST",
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is included
                                },
                                body: JSON.stringify({
                                    library_id: rfid
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data); // Debugging: log the response
                                if (data.success) {
                                    message.textContent = 'Welcome, ' + data.patron_name;
                                    // Assuming patron_id is a hidden input
                                    document.getElementById('patron_id').value = data.patron_id;
                                    patron_details.style.display =
                                        "block"; // Show the patron details form
                                } else {
                                    message.textContent = data.message_error;
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error); // Debugging: log the error response
                                message.textContent = 'An error occurred. Please try again.';
                            });

                        // Clear the RFID input after submission
                        rfid_input.value = "";
                        ReloadPage()
                    }
                }
            });

            // Handle submission of Purpose and Marketer via Fetch API
            document.getElementById("submit_login").addEventListener("click", function() {
                let purpose_id = document.getElementById("purpose_id").value;
                let marketer_id = document.getElementById("marketer_id").value;

                if (purpose_id) {
                    fetch("/patrons/login/update", {
                            method: "POST",
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is included
                            },
                            body: JSON.stringify({
                                patron_id: document.getElementById('patron_id').value,
                                purpose_id: purpose_id,
                                marketer_id: marketer_id
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            message.textContent = data.message_success;
                            patron_details.style.display =
                                "none"; // Hide the form after successful submission
                        })
                        .catch(error => {
                            message.textContent = 'An error occurred. Please try again.';
                        });
                } else {
                    message.textContent = "Please select a purpose before submitting.";
                }
            });

            function ReloadPage() {
                // Clear the existing timer if it's set
                if (reloadTimer) {
                    clearTimeout(reloadTimer);
                }

                // Set a new timer for 10 seconds
                reloadTimer = setTimeout(() => {
                    location.reload(); // Reload after 10 seconds
                }, 20000); // 20 seconds
            }
        });
    </script>
@endsection
