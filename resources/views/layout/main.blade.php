<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>

<body>
    <div class="login-page">
        @yield('login-content')
    </div>
    <div class="user-page">
        @yield('user-content')
    </div>
    <div class="patron-page">
        @yield('patron-content')
    </div>
</body>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>
<script type="module" src="{{asset('js/chart.umd.js')}}"></script>
</html>
