@extends('layout.main')
@extends('modals.material.import')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    @include('include.material_tabs')
    <div class="bg-white p-3" style="min-width: fit-content">
        <div class="d-flex flex-row flex-wrap justify-content-start gap-2 mb-3">
            <div>
                <a class="btn-simple" href="/material/create">Add material</a>
                <a class="btn-simple" href="/borrow-material">Borrow Material</a>
                <a class="btn-simple" href="/return-material">Return Material</a>
                <button class="btn-simple" type="button" data-bs-toggle="modal"
                    data-bs-target="#importMaterials">Import</button>
                <a class="btn-simple" href="/materials/export">Export</a>
            </div>
        </div>
        <div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Form to filter materials -->
                <div>
                    <form method="GET" action="/materials" class="d-flex flex-row align-items-center gap-2" id="filterForm">
                        <input type="text" name="search" placeholder="Search by title or author"
                            value="{{ $search }}">
    
                        <!-- Category filter -->
                        <select name="category">
                            <option value="all" {{ $category === 'all' ? 'selected' : '' }}>All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->category_id }}" {{ $category == $cat->category_id ? 'selected' : '' }}>
                                    {{ $cat->category }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Status filter/legend -->
                <div class="d-flex flex-row align-items-center gap-2">
                    @foreach (['all', 'available', 'borrowed', 'overdue'] as $item)
                        <a href="?status={{ $item }}" class="legend-btn {{ $status === $item ? 'active' : '' }}">
                            {{ ucfirst($item) }}
                        </a>
                    @endforeach
                    <div class="dropdown">
                        <button class="btn text-white dropdown-toggle" style="background-color: #0E1133" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Sort
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => $direction === 'asc' && $sort === 'title' ? 'desc' : 'asc']) }}">
                                    Title
                                    @if ($sort === 'title')
                                        <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
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
                            <span class="badge bg-success"><span class="badge-label">Available:</span>
                                {{ $availableCount }}</span>
                        @endif
                        @if ($borrowedCount > 0)
                            <span class="badge bg-warning"><span class="badge-label">Borrowed:</span>
                                {{ $borrowedCount }}</span>
                        @endif
                        @if ($overdueCount > 0)
                            <span class="badge bg-danger"><span class="badge-label">Overdue:</span>
                                {{ $overdueCount }}</span>
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
                    <div class="row data">Author(s):
                        {{ $material->authors->isNotEmpty() ? $material->authors->pluck('name')->implode(', ') : 'None' }}
                    </div>
                    <div class="row data">Isbn: {{ $material->isbn ?? 'None' }}</div>
                    <div class="row data">Issn: {{ $material->issn ?? 'None' }}</div>
                    <div class="row data">Category: {{ $material->category->category ?? 'None' }}</div>
                </div>
                <div class="col">
                    <div class="row data">Editors(s):
                        {{ $material->editors->isNotEmpty() ? $material->editors->pluck('name')->implode(', ') : 'None' }}
                    </div>
                    <div class="row data">Illustrator(s):
                        {{ $material->illustrators->isNotEmpty() ? $material->illustrators->pluck('name')->implode(', ') : 'None' }}
                    </div>
                    <div class="row data">Translator(s):
                        {{ $material->translators->isNotEmpty() ? $material->translators->pluck('name')->implode(', ') : 'None' }}
                    </div>
                    <div class="row data">Publisher: {{ $material->publisher->name ?? 'None' }}</div>
                </div>
                <div class="col">
                    <div class="row data">Publication Year: {{ $material->publication_year ?? 'None' }}</div>
                    <div class="row data">Edition: {{ $material->edition ?? 'None' }}</div>
                    <div class="row data">Volume: {{ $material->volume ?? 'None' }}</div>
                    <div class="row data">Pages: {{ $material->pages ?? 'None' }}</div>
                </div>
            </a>
        @endforeach
        {{-- pagination --}}
        <div class="fixed-bottom mt-4 d-flex justify-content-center">
            {{ $materials->links() }}
        </div>
    </div>
    <script>
        // Get the category dropdown element
        const categorySelect = document.querySelector('select[name="category"]');

        // Attach a change event listener to the category dropdown
        categorySelect.addEventListener('change', function() {
            // Get the form by its ID and submit it
            document.getElementById('filterForm').submit();
        });
    </script>
@endsection
