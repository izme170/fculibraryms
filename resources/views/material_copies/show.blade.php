@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    <div class="bg-white p-3 rounded" style="min-width: fit-content">
        <a href="/material/show/{{ $copy->material->material_id }}" class="text-decoration-none text-dark">
            <x-lucide-arrow-left width="30" class="mb-2" />
        </a>
    <div class="row"><h1>{{ $copy->material->title }}</h1></div>
    <div class="row mb-3">
        <div class="col">
            <div><span class="fw-bold">Copy No.: </span>{{ $copy->copy_number }}</div>
            <div><span class="fw-bold">Accession No.: </span>{{ $copy->accession_number ?? "None" }}</div>
            <div><span class="fw-bold">Call No.: </span>{{ $copy->call_number ?? "None" }}</div>
            <div><span class="fw-bold">Price: </span>{{ $copy->price ?? "None" }}</div>
        </div>
        <div class="col">
            <div><span class="fw-bold">Vendor: </span>{{ $copy->vendor->name }}</div>
            <div><span class="fw-bold">Funding Source: </span>{{ $copy->fund->name ?? "None" }}</div>
            <div><span class="fw-bold">Acquisition Date: </span>{{ $copy->date_acquired ? $copy->date_acquired->format('M d, Y') : "None"}}</div>
            <div><span class="fw-bold">RFID: </span>{{ $copy->rfid }}</div>
        </div>
    </div>
    <div class="d-flex gap-1 mb-3">
        <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#editMaterialCopy">Update</button>
        @if (!$copy->is_archived)
            <button class="btn-simple" type="button" data-bs-toggle="modal"
                data-bs-target="#archiveMaterialCopy">Archive</button>
        @else
            <a class="btn-simple" href="/material/unarchive/copy/{{ $copy->copy_id }}">Unarchive</a>
        @endif
        <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#updateMaterialCopyRFID">Assign new
            RFID</button>
    </div>
    <div class="row">
        <div>
            <h5>Previous Borrowers</h5>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Date Returned</th>
                        <th scope="col">Before</th>
                        <th scope="col">After</th>
                        <th scope="col">Fine</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($copy->borrowedCopies as $borrower)
                        <tr onclick="window.location.href='/borrowed-material/show/{{ $borrower->borrow_id }}';"
                            style="cursor:pointer;">
                            <td>{{ $borrower->patron->type->type }}</td>
                            <td>{{ $borrower->patron->first_name }} {{ $borrower->patron->last_name }}</td>
                            <td>{{ $borrower->created_at->format('m/d/y h:i a') }}</td>
                            <td>{{ $borrower->returned ? $borrower->returned->format('m/d/y h:i a') : 'Unreturned' }}
                            </td>
                            <td>{{ $borrower->conditionBefore->name ?? 'Not indicated' }}</td>
                            <td>{{ $borrower->returned ?($borrowed_material->conditionAfter->name ?? 'Not indicated') : "Pending" }}</td>
                            <td>₱{{ $borrower->fine }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('modals.material_copy.edit')
    @include('modals.material_copy.archive')
    @include('modals.material_copy.new_rfid')
@endsection
