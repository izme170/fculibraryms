@extends('layout.main')
@include('include.sidenav')

@section('user-content')
    @include('include.topbar')
    <div class="bg-white p-3 rounded" style="min-width: fit-content">
        <a href="{{ url()->previous() }}" class="text-decoration-none text-dark">
            <x-lucide-arrow-left width="30" class="mb-2" />
        </a>
        <h2>Borrowed Material Details</h2>
        <div class="row mb-3">
            <div class="col">
                <img class="img-thumbnail img-fluid"
                    src="{{ $borrowed_material->patron->patron_image ? asset('storage/' . $patron->patron_image) : asset('img/default-patron-image.png') }}"
                    alt="Patron Image" id="image-preview" width="200px" height="200px"
                    onclick="window.location.href='/patron/show/{{ $borrowed_material->patron->patron_id }}';"
                    style="cursor:pointer;">
                <div><span class="fw-bold">Borrower:
                    </span>{{ $borrowed_material->patron ? $borrowed_material->patron->first_name . ' ' . $borrowed_material->patron->last_name : 'N/A' }}
                </div>
            </div>
            <div class="col">
                <img class="img-thumbnail img-fluid"src="{{ $borrowed_material->materialCopy->material->material_image ? asset('storage/' . $material->material_image) : asset('img/default-material-image.png') }}"
                    alt="Material Image" id="material-image-preview" width="200px" height="200px" onclick="window.location.href='/material/show/{{ $borrowed_material->materialCopy->material->material_id }}';"
                    style="cursor:pointer;">
                <div><span class="fw-bold">Title: </span>{{ $borrowed_material->materialCopy->material->title ?? 'N/A' }}
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div><span class="fw-bold">Due Date:
                    </span>{{ $borrowed_material->due_date ? \Carbon\Carbon::parse($borrowed_material->due_date)->format('F j, Y') : 'N/A' }}
                </div>
                <div><span class="fw-bold">Returned:
                    </span>{{ $borrowed_material->returned ? \Carbon\Carbon::parse($borrowed_material->returned)->format('F j, Y') : 'Not Returned' }}
                </div>
                <div><span class="fw-bold">Fine: </span>{{ $borrowed_material->fine ?? 0 }}</div>
            </div>
            <div class="col">
                <div><span class="fw-bold">Copy Number: </span>{{ $borrowed_material->materialCopy->copy_number ?? 'N/A' }}
                </div>
                <div><span class="fw-bold">Call Number: </span>{{ $borrowed_material->materialCopy->call_number ?? 'N/A' }}
                </div>
                <div><span class="fw-bold">Accession Number:
                    </span>{{ $borrowed_material->materialCopy->accession_number ?? 'N/A' }}</div>
                <div><span class="fw-bold">Condition Before:
                    </span>{{ $borrowed_material->conditionBefore->name ?? 'N/A' }}</div>
                <div><span class="fw-bold">Condition After: </span>{{ $borrowed_material->conditionAfter->name ?? 'N/A' }}
                </div>
            </div>
        </div>
    </div>
@endsection
