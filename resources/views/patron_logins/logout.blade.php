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
        <h4 class="text-white">Library Patron Logout</h4>
    </div>

    <div class="login-page">
        <div class="login-card">
            <h2>Please, scan your RFID to Logout</h2>
            <form id="rfid_form">
                @csrf
                <input type="text" id="rfid_input" name="library_id" placeholder="Scan RFID to Logout">
                <h1 id="message"></h1>
                <div class="rfid-icon"><x-lucide-radio /></div>
                <div class="footer">Filamer Christian University Library</div>
            </form>
        </div>
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
                            body: JSON.stringify({
                                library_id: rfid
                            })
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
