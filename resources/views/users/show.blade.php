@extends('layout.main')
@include('include.sidenav_admin')
@section('user-content')
<h1>{{$user->first_name . ' ' . $user->last_name}}</h1>
<p>{{$user->role_id}}</p>
<p>Contact Number: {{$user->contact_number}}</p>
<p>Email: {{$user->email}}</p>
<p>Address: {{$user->address}}</p>
<p>Department: {{$user->username}}</p>

<a class="btn-simple" href="/admin/user/edit/{{$user->user_id}}">Update</a>
<a class="btn-simple" href="/admin/user/archive/{{$user->user_id}}">Archive</a>
<a class="btn-simple" href="/admin/user/change-password/{{$user->user_id}}">Change Password</a>
@endsection