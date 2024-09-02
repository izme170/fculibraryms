@extends('layout.main')
@include('include.sidenav_admin')
@section('user-content')
    <div class="mb-3 qrcode"><img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(300)->generate($qrcode)) }}" alt="qr"></div>
    <a class="btn-simple" href="/admin/patron/qrcode/print">Print QR Code</a>
    <a class="btn-simple" href="/admin/patron/qrcode/send-to-email/{{$patron->patron_id}}">Send via E-mail</a>
    <a class="btn-simple" href="/admin/patron/create">Add another patron</a>
@endsection