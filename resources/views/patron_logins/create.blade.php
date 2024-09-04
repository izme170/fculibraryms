@extends('layout.main')
@section('patron-content')
<div class="container">
    <h1>RFID Login</h1>
    <div class="mb-3">
        <label for="rfid_input">RFID</label>
        <input type="text" id="rfid_input" name="library_id" autofocus>
    </div>
    <form action="/patrons/login/store" method="post">
        @csrf
        <div class="mb-3">
            <label for="patron_name">Patron Name</label>
            <input type="text" id="patron_name" readonly>
            <input type="text" id="patron_id" name="patron_id" readonly hidden>
        </div>
        <div class="mb-3">
            <label for="purpose_id">Purpose</label>
            <select id="purpose_id" name="purpose_id">
                <option value="">Select Purpose</option>
                @foreach ($purposes as $purpose)
                    <option value="{{ $purpose->purpose_id }}" {{$purpose->purpose_id == 1 ? 'selected' : ''}}>{{ $purpose->purpose }}</option>
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
        <button type="submit" class="btn-simple">Submit</button>
    </form>
</div>
@include('include.messages')

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const inputField = document.getElementById('rfid_input');
        inputField.focus();

        function resetInput() {
            inputField.value = '';
            inputField.focus();
        }

        function handleRFIDScan(rfid) {
            fetch(`/get-patron/${rfid}`)
                .then(response => response.json())
                .then(data => {
                    if (data.name) {
                        document.getElementById('patron_name').value = data.name;
                        document.getElementById('patron_id').value = data.patron_id;
                    } else {
                        alert('RFID not Exist. Please Contact the Library Admin');
                    }
                    resetInput();
                })
                .catch(error => console.error('Error fetching patron', error));
        }

        // Handle RFID input field changes
        inputField.addEventListener('input', function () {
            const rfid = inputField.value.trim();
            if (rfid) {
                handleRFIDScan(rfid);
            }
        });

        // Handle keydown event to capture input for RFID field
        document.addEventListener('keydown', function (event) {
            if (event.key.length === 1 && /[a-zA-Z0-9]/.test(event.key)) {
                // Append the key to the input field value
                inputField.value += event.key;
                event.preventDefault(); // Prevent default action to avoid adding the key to other inputs
            } else if (event.key === 'Enter') {
                const rfid = inputField.value.trim();
                if (rfid) {
                    handleRFIDScan(rfid);
                }
                resetInput();
            }
        });

        // Reset input field on page load
        resetInput();
    });
</script>
@endsection

<!-- <!DOCTYPE html>
<html>

<head>
    <title>Patron Login</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="{{ asset('js/instascan.min.js') }}"></script>
</head>

<body>
    <div class="container">
        <video id="preview"></video>

        <div>
            <label for="patron_name">Patron Name</label>
            <input type="text" id="patron_name" readonly>
            <input type="hidden" id="patron_id">
        </div>

        <div>
            <label for="purpose_id">Purpose</label>
            <select id="purpose_id">
                <option value="">Select Purpose</option>
                @foreach ($purposes as $purpose)
                    <option value="{{ $purpose->purpose_id }}">{{ $purpose->purpose }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="marketer_id">Marketer</label>
            <select id="marketer_id">
                <option value="">Select Marketer</option>
                @foreach ($marketers as $marketer)
                    <option value="{{ $marketer->marketer_id }}">{{ $marketer->marketer }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn-simple" id="submitBtn">Submit</button>
    </div>

    <script>
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

        scanner.addListener('scan', function (content) {
            fetch(`/get-patron/${content}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('patron_name').value = data.name;
                    document.getElementById('patron_id').value = data.patron_id; // Store patron_id in hidden input
                })
                .catch(() => alert('Error fetching patron.'));
        });

        Instascan.Camera.getCameras().then(cameras => {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('No cameras found.');
            }
        }).catch(() => alert('Error accessing camera.'));

        document.getElementById('submitBtn').addEventListener('click', () => {
            const patronId = document.getElementById('patron_id').value;
            const purposeId = document.getElementById('purpose_id').value;
            const marketerId = document.getElementById('marketer_id').value;

            if (patronId && purposeId && marketerId) {
                fetch('/patron-logins', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        patron_id: patronId,
                        purpose_id: purposeId,
                        marketer_id: marketerId
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Patron login recorded successfully!');
                            document.getElementById('patron_name').value = '';
                            document.getElementById('purpose_id').value = '';
                            document.getElementById('marketer_id').value = '';
                        } else {
                            alert('Failed to record patron login.');
                        }
                    })
                .catch (() => alert('Error saving login.'));
            } else {
                alert('All fields are required.');
            }
        });
    </script>
</body>

</html> -->