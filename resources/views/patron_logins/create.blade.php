@extends('layout.main')
@section('patron-content')
    <style>
        .login-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            color: #fff;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            min-width: 300px;
        }

        .rfid-icon {
            width: 60px;
            height: 60px;
            margin: 20px auto;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #ccc;
        }
    </style>

    <div class="fixed-top p-3 d-flex flex-row justify-content-start align-items-center gap-3"
        style="background-color: #0e1133">
        <img src="{{ asset('img/fcu-logo.png') }}" alt="fcu-logo" width="30">
        <h4 class="text-white mb-0">Patron Login</h4>
    </div>
    <div class="login-page">
        <div class="login-card">
            <div>
                <h2 id="message">Please Scan Your RFID</h2>
            </div>
            <input type="text" id="rfid_input" name="library_id" placeholder="Scan RFID here">
            <input type="hidden" id="patron_id" name="patron_id">
            <div id="patron_details" style="display:none;">
                <div class="d-flex gap-3">
                    <img id="patron_image" src="" alt="Patron Photo" width="150">
                    <div>
                        <div class="mb-3">
                            <label class="text-white" for="purpose_id">Purpose</label>
                            <select id="purpose_id" name="purpose_id">
                                <option value="">Select Purpose</option>
                                @foreach ($purposes as $purpose)
                                    <option value="{{ $purpose->purpose_id }}">{{ $purpose->purpose }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="text-white" for="marketer_id">Marketer</label>
                            <select id="marketer_id" name="marketer_id">
                                <option value="">Select Marketer</option>
                                @foreach ($marketers as $marketer)
                                    <option value="{{ $marketer->marketer_id }}">{{ $marketer->marketer }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button id="submit_login" class="btn-simple mb-3">Submit</button>
            </div>
            <div class="rfid-icon"><x-lucide-radio /></div>
            <div class="footer">Filamer Christian University Library</div>
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
                                    message.textContent = 'Welcome, ' + data.patron.name;
                                    // Assuming patron_id is a hidden input
                                    document.getElementById('patron_id').value = data.patron.id;
                                    document.getElementById("patron_image").src = data.patron.image;
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

                reloadTimer = setTimeout(() => {
                    location.reload(); // Reload after 60 seconds
                }, 60000); // 60 seconds
            }
        });
    </script>
@endsection
