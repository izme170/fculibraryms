@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    @include('include.material_tabs')
    <div class="bg-white p-3" style="min-width: fit-content">
        <form method="GET" action="/materials/archives" class="d-flex flex-row align-items-center gap-2" id="filterForm">
            <input type="text" name="search" placeholder="Search..."
                value="{{ $search }}">
        </form> 
        @foreach ($materials as $material)
            <a class="row align-items-center mb-3 card-list" href="/material/show/{{ $material->material_id }}"
                data-status="{{ $material->status }}">
                <div class="col ps-0" style="max-width: fit-content">
                    <div class="indicator-container">
                        @php
                            $availableCount = $material->materialCopies->where('status', 'Available')->count();
                            $borrowedCount = $material->materialCopies->where('status', 'Borrowed')->count();
                            $overdueCount = $material->materialCopies->where('status', 'Overdue')->count();
                        @endphp

                        @if ($availableCount > 0)
                            <span class="badge bg-success"><span class="badge-label">Available:</span> {{ $availableCount }}</span>
                        @endif
                        @if ($borrowedCount > 0)
                            <span class="badge bg-warning"><span class="badge-label">Borrowed:</span> {{ $borrowedCount }}</span>
                        @endif
                        @if ($overdueCount > 0)
                            <span class="badge bg-danger"><span class="badge-label">Overdue:</span> {{ $overdueCount }}</span>
                        @endif
                    </div>
                    {{-- <div class="indicator-container">
                        <div class="status-indicator {{ $material->status }}"></div>
                    </div> --}}
                    <img class="img"
                        src="{{ $material->material_image ? asset('storage/' . $material->material_image) : asset('img/default-material-image.png') }}"
                        alt="">
                </div>
                <div class="col">
                    <div class="row title">{{ $material->title }}</div>
                    <div class="row data">Author(s): {{ $material->authors->isNotEmpty() ? $material->authors->pluck('name')->implode(', ') : "None"}}</div>
                    <div class="row data">Isbn: {{ $material->isbn ?? "None" }}</div>
                    <div class="row data">Issn: {{ $material->issn ?? "None"}}</div>
                    <div class="row data">Category: {{ $material->category->category ?? "None"}}</div>
                </div>
                <div class="col">
                    <div class="row data">Editors(s): {{ $material->editors->isNotEmpty() ? $material->editors->pluck('name')->implode(', ') : "None"}}</div>
                    <div class="row data">Illustrator(s): {{ $material->illustrators->isNotEmpty() ? $material->illustrators->pluck('name')->implode(', ') : "None"}}</div>
                    <div class="row data">Translator(s): {{ $material->translators->isNotEmpty() ? $material->translators->pluck('name')->implode(', ') : "None"}}</div>
                    <div class="row data">Publisher: {{ $material->publisher->name ?? "None"}}</div>
                </div>
                <div class="col">
                    <div class="row data">Publication Year: {{ $material->publication_year ?? "None"}}</div>
                    <div class="row data">Edition: {{ $material->edition ?? "None"}}</div>
                    <div class="row data">Volume: {{ $material->volume ?? "None"}}</div>
                    <div class="row data">Pages: {{ $material->pages ?? "None"}}</div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
