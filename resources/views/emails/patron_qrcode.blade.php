<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your FCU Library QR Code</title>
    <style>
        .qr-container {
            background-color: #f0f0f0;
            padding: 20px; 
            display: inline-block; 
            border-radius: 10px;
        }
        .qr-code {
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <img src="{{asset('img/fcu-logo.png')}}" alt="">
    <h1>Your QR Code</h1>
    <p>Thank you! Please use this QRCode everytime you enter in FCU Library:</p>

    <div class="qr-container">
        <img src="{{ asset('storage/qrcodes/' . $qrcodeImagePath) }}" class="qr-code" alt="QR Code">
    </div>
</body>
</html>
