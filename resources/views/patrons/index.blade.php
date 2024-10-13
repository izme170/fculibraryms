@extends('layout.main')
@include('include.sidenav')
@section('user-content')
<a class="btn-simple" href="/patron/create">Add Patron</a>
<a class="btn-simple" href="/patrons/export">Export</a>
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
            <tr onclick="window.location.href='/patron/show/{{$patron->patron_id}}';" style="cursor:pointer;">
                <td>{{$patron->first_name . ' ' . $patron->last_name}}</td>
                <td>{{$patron->type}}</td>
                <td>{{$patron->contact_number}}</td>
                <td>{{$patron->email}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
