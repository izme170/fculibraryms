@extends('layout.main')
@section('login-content')
<div class="login-container">
    <div class="brand">
        <img src="{{asset('img/fcu-logo.png')}}" alt="fcu-logo">
        <span>FCU Library Management System</span>
    </div>
    <div class="login-form">
        <h1>Authentication</h1>
        <form action="/authenticate" method="post">
            @CSRF
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" autofocus>
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>
            <button class="btn-simple" type="submit">Login</button>
        </form>
    </div>
</div>
@endsection
