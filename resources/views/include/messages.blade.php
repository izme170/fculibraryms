@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session()->has('message_success'))
	<div class="alert alert-success" role="alert">
		{{ session('message_success') }}
	</div>
@endif

@if (session()->has('message_error'))
	<div class="alert alert-danger" role="alert">
		{{ session('message_error') }}
	</div>
@endif

@if (session()->has('message_success_xl'))
	<h1 id="message">{{ session('message_success_xl') }}</h1>
@endif

@if (session()->has('message_error_xl'))
	<h1 id="message">{{ session('message_error_xl') }}</h1>
@endif