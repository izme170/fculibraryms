@extends('layout.main')
@include('include.sidenav_admin')
@section('user-content')
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Action</th>
            <th scope="col">Entity</th>
            <th scope="col">Initiator</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($activities as $activity)
            <tr>
                <td>{{$activity->created_at}}</td>
                <td>{{$activity->action}}</td>
                <td>{{$activity->patron_id}}{{$activity->book_id}}</td>
                <td>{{$activity->user_id}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection