@extends('layout.main')
@include('include.sidenav_admin')
@section('user-content')
<a class="btn-simple" href="/admin/patron/create">Add Patron</a>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Patron Type</th>
            <th scope="col">Contact Number</th>
            <th scope="col">Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($patrons as $patron)
            <tr onclick="window.location.href='/admin/patron/show/{{$patron->patron_id}}';" style="cursor:pointer;">
                <td>{{$patron->first_name . ' ' . $patron->last_name}}</td>
                <td>{{$patron->type}}</td>
                <td>{{$patron->contact_number}}</td>
                <td>{{$patron->email}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- <table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Contact Number</th>
            <th>Patron Type</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($patrons as $patron)
            <tr>
                <td>{{$patron->first_name . ' ' . $patron->last_name}}</td>
                <td>{{$patron->email}}</td>
                <td>{{$patron->contact_number}}</td>
                <td>{{$patron->type_id}}</td>
            </tr>
        @endforeach
    </tbody>
</table> -->
@endsection