@extends('layout.main')
@include('include.sidenav')
@section('user-content')
<h1>{{$patron->first_name}} {{$patron->last_name}}</h1>
<p>{{$patron->type_id}}</p>
<p>{{$patron->library_id}}</p>
<p>Contact Number: {{$patron->contact_number}}</p>
<p>Email: {{$patron->email}}</p>
<p>Address: {{$patron->address}}</p>
<p>Department: {{$patron->department_id}}</p>
<p>Course: {{$patron->course_id}}</p>

<a class="btn-simple" href="/patron/edit/{{$patron->patron_id}}">Update</a>
<a class="btn-simple" href="/patron/archive/{{$patron->patron_id}}">Archive</a>
<a class="btn-simple" href="/patron/edit/{{$patron->patron_id}}">Assign new RFID</a>
@endsection
