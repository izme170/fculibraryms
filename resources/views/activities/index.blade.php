@extends('layout.main')
@include('include.sidenav')
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
                <td>{{$activity->name}}{{$activity->patron_first_name}} {{$activity->patron_last_name}}</td>
                <td>{{$activity->user_first_name}} {{$activity->user_last_name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
