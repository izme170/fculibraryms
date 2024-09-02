<!DOCTYPE html>
<html>

<head>
    <title>Instascan</title>
    <script src="{{ asset('js/instascan.min.js') }}"></script>
</head>

<body>
    <div class="container">
        <video id="preview"></video>

        <!-- Patron Name -->
        <div>
            <label for="patron_name">Patron Name</label>
            <input type="text" id="patron_name" readonly>
            <input type="hidden" id="patron_id"> <!-- Hidden field to store patron_id -->
        </div>

        <!-- Purpose Selection -->
        <div>
            <label for="purpose_id">Purpose</label>
            <select id="purpose_id">
                <option value="">Select Purpose</option>
                @foreach ($purposes as $purpose)
                    <option value="{{ $purpose->purpose_id }}">{{ $purpose->purpose }}</option>
                @endforeach
            </select>
        </div>

        <!-- Marketer Selection -->
        <div>
            <label for="marketer_id">Marketer</label>
            <select id="marketer_id">
                <option value="">Select Marketer</option>
                @foreach ($marketers as $marketer)
                    <option value="{{ $marketer->marketer_id }}">{{ $marketer->marketer }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <button id="submitBtn">Submit</button>
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

</html>