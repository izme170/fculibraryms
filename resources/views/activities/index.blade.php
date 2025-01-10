@extends('layout.main')
@include('include.sidenav')
@section('user-content')
<div class="container p-3 rounded">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Action</th>
                <th scope="col">Entity</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                <tr>
                    <td>{{$activity->initiator->first_name}} {{$activity->initiator->last_name}} {{$activity->action}}</td>
                    <td>{{$activity->book->title ?? ''}}{{$activity->patron->first_name ?? ''}} {{$activity->patron->last_name ?? ''}}{{$activity->user->first_name ?? ''}} {{$activity->user->last_name ?? ''}}</td>
                    <td>{{$activity->created_at->format('F j, Y, g:i a')}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
