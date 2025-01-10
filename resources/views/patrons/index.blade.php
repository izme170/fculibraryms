@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <div class="bg-white rounded p-3" style="min-width: fit-content">
        <div>
            <a class="btn-simple" href="/patron/create">Add Patron</a>
            <a class="btn-simple" href="/patrons/export">Export</a>
        </div>
        <div class="d-flex flex-wrap gap-3 mt-3 justify-content-center">
            @foreach ($patrons as $patron)
                <a class="card text-decoration-none" href="/patron/show/{{ $patron->patron_id }}"
                    data-status="{{ $patron->status }}">
                    <div class="img" style="background-image: url('{{ asset('img/default-patron-image.png') }}');">
                    </div>
                    <div class="text">
                        <p class="h3">{{ $patron->first_name }} {{ $patron->last_name }}</p>
                        <p class="p">{{ $patron->type }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection

{{-- <table class="table">
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
            <tr onclick="window.location.href='/patron/show/{{ $patron->patron_id }}';" style="cursor:pointer;">
                <td>{{ $patron->first_name . ' ' . $patron->last_name }}</td>
                <td>{{ $patron->type }}</td>
                <td>{{ $patron->contact_number }}</td>
                <td>{{ $patron->email }}</td>
            </tr>
        @endforeach
    </tbody>
</table> --}}
