@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    @include('include.material_tabs')
    <div class="bg-white p-3" style="min-width: fit-content">
        <div class="d-flex flex-row flex-wrap justify-content-around gap-2">
            <form method="GET" action="/material-copies" class="d-flex flex-row align-items-center gap-2" id="filterForm">
                <input type="text" name="search" placeholder="Search..." value="{{ $search }}">
            </form>

            <div class="d-flex flex-row align-items-center gap-2">
                <a href="?status=all" class="legend-btn {{ $status === 'all' ? 'active' : '' }}">All</a>
                <a href="?status=available"
                    class="legend-btn {{ $status === 'available' ? 'active' : '' }}">Available</a>
                <a href="?status=borrowed"
                    class="legend-btn {{ $status === 'borrowed' ? 'active' : '' }}">Borrowed</a>
                <a href="?status=overdue" class="legend-btn {{ $status === 'overdue' ? 'active' : '' }}">Overdue</a>
            </div>
        </div>
        @foreach ($copies as $copy)
            <a class="row align-items-center mb-3 card-list" href="/copy/show/{{ $copy->copy_id }}">
                <div class="col ps-0" style="max-width: fit-content">
                    <div class="indicator-container">
                        <div class="indicator-container">
                            <div class="status-indicator {{ $copy->status }}"></div>
                        </div>
                    </div>
                    <img class="img"
                        src="{{ $copy->material->material_image ? asset('storage/' . $copy->material->material_image) : asset('img/default-material-image.png') }}"
                        alt="">
                </div>
                <div class="col">
                    <div class="row title">{{ $copy->material->title }}</div>
                    <div class="row data">Copy Number: {{ $copy->copy_number ?? 'None' }}</div>
                    <div class="row data">RFID: {{ $copy->rfid ?? 'None' }}</div>
                    <div class="row data">Accession: {{ $copy->accession_number ?? 'None' }}</div>
                    <div class="row data">Call Number: {{ $copy->call_number ?? 'None' }}</div>
                </div>
                <div class="col">
                    <div class="row data">Price: {{ $copy->price ?? 'None' }}</div>
                    <div class="row data">Vendor: {{ $copy->vendor->name ?? 'None' }}</div>
                    <div class="row data">Fund: {{ $copy->fund->name ?? 'None' }}</div>
                    <div class="row data">Date Acquired: {{ $copy->date_acquired ?? 'None' }}</div>
                    <div class="row data">Condition: {{ $copy->condition->name ?? 'None' }}</div>
                </div>
            </a>
        @endforeach
    </div>

    {{-- pagination --}}
    <div class="fixed-bottom mt-4 d-flex justify-content-center">
        {{ $copies->links() }}
    </div>
@endsection
