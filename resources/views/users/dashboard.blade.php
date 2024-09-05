@extends('layout.main')
@include('include.sidenav_admin')
@section('user-content')
<a class="btn-simple" href="/borrow-book">Borrow Book</a>
<a class="btn-simple" href="/return-book">Return Book</a>
<div class="container">

<script src="{{ asset('js/bargraph.js') }}"></script>
<div style="width: 800px;"><canvas id="acquisitions"></canvas></div>

    <div class="mb-3">
        <h4>Daily Visits</h4>
        <div class="daily-visits">
            <ul>
                @foreach ($visits as $day => $count)
                    <li>
                        <span>{{ $count }}</span>
                        <label>{{ ["M", "T", "W", "T", "F", "S", "S"][$day - 1] }}</label>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<style>
    .daily-visits {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        height: 150px;
    }
    .daily-visits ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
    }
    .daily-visits li {
        width: 20px;
        background-color: #212832;
        text-align: center;
        color: #fff;
        margin: 0 5px;
        position: relative;
    }
    .daily-visits li label {
        position: absolute;
        bottom: -20px;
        width: 100%;
        text-align: center;
        color: #000;
    }
    .daily-visits li span {
        position: absolute;
        top: -20px;
        width: 100%;
        text-align: center;
        color: #000;
    }
</style>
@endsection