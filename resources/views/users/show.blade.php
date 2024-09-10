@extends('layout.main')
@include('include.sidenav')
@section('user-content')
<h1>{{$user->first_name . ' ' . $user->last_name}}</h1>
<p>{{$user->role}}</p>
<p>Contact Number: {{$user->contact_number}}</p>
<p>Email: {{$user->email}}</p>
<p>username: {{$user->username}}</p>

<a class="btn-simple" href="/user/edit/{{$user->user_id}}">Update</a>
<a class="btn-simple" href="/user/archive/{{$user->user_id}}">Archive</a>
<a class="btn-simple" href="/user/change-password/{{$user->user_id}}">Change Password</a>
@endsection
