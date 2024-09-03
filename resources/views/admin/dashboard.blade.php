@extends('layout.main')
@include('include.sidenav_admin')
@section('user-content')
    <a class="btn-simple" href="/borrow-book">Borrow Book</a>
    <a class="btn-simple" href="/return-book">Return Book</a>
@endsection