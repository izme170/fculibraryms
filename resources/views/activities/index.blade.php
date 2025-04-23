@extends('layout.main')
@include('include.sidenav')
@section('user-content')
@include('include.topbar')
    <div class="bg-white p-3 rounded" style="min-width: fit-content">
        <div class="d-flex justify-content-between">
            <!-- Form to filter -->
            <form method="GET" action="/activities" class="d-flex flex-row align-items-center" id="filterForm">
                <input type="date" name="date" value="{{ $date }}">
                <button type="submit" class="btn-rectangle">Filter</button>
            </form>
            <!-- Form to search -->
            <form method="GET" action="/activities" class="d-flex flex-row align-items-center" id="filterForm">
                <input type="text" name="search" placeholder="Search by title or author"
                    value="{{ $search }}">
            </form>
            <a href="/activities" type="submit" class="btn">Show All</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Action</th>
                    <th scope="col">Entity</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                    <tr>
                        <td><a href="/user/show/{{ $activity->initiator->user_id }}"
                                class="shortcut-link" draggable="false">{{ $activity->initiator->first_name }}
                                {{ $activity->initiator->last_name }}</a>
                            {{ $activity->action }}</td>
                        <td>
                            @isset($activity->material->title)
                                <a href="/material/show/{{ $activity->material->material_id }}"
                                    class="shortcut-link" draggable="false">{{ $activity->material->title }}</a>
                            @endisset
                            @isset($activity->patron->first_name)
                                <a href="/patron/show/{{ $activity->patron->patron_id }}"
                                    class="shortcut-link" draggable="false">{{ $activity->patron->first_name }}
                                    {{ $activity->patron->last_name }}</a>
                            @endisset
                            @isset($activity->user->first_name)
                                <a href="/user/show/{{ $activity->user->user_id }}"
                                    class="shortcut-link" draggable="false">{{ $activity->user->first_name }}
                                    {{ $activity->user->last_name }}</a>
                            @endisset
                            {{-- {{ $activity->material->title ?? '' }}{{ $activity->patron->first_name ?? '' }}
                            {{ $activity->patron->last_name ?? '' }}{{ $activity->user->first_name ?? '' }}
                            {{ $activity->user->last_name ?? '' }} --}}
                        </td>
                        <td>{{ $activity->created_at->format('F j, Y, g:i a') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
