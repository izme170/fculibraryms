@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    <div class="row"><h1>{{ $copy->book->title }}</h1></div>
    <div class="row mb-3">
        <div class="col">
            <div><span class="fw-bold">Copy No.: </span>{{ $copy->rfid }}</div>
            <div><span class="fw-bold">Accession No.: </span>{{ $copy->accession_number }}</div>
            <div><span class="fw-bold">Call No.: </span>{{ $copy->call_number }}</div>
            <div><span class="fw-bold">Price: </span>{{ $copy->price }}</div>
        </div>
        <div class="col">
            <div><span class="fw-bold">Vendor: </span>{{ $copy->vendor->name }}</div>
            <div><span class="fw-bold">Funding Source: </span>{{ $copy->fundingSource->name }}</div>
            <div><span class="fw-bold">Acquisition Date: </span>{{ $copy->date_acquired->format('M d, Y') }}</div>
            <div><span class="fw-bold">RFID: </span>{{ $copy->rfid }}</div>
        </div>
    </div>
    <div class="row">
        <div>
            <h5>Previous Borrowers</h5>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Date Returned</th>
                        <th scope="col">Fine</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($copy->borrowedCopies as $borrower)
                        <tr>
                            <td>{{ $borrower->patron->type->type }}</td>
                            <td>{{ $borrower->patron->first_name }} {{ $borrower->patron->last_name }}</td>
                            <td>{{ $borrower->created_at->format('m/d/y h:i a') }}</td>
                            <td>{{ $borrower->returned ? $borrower->returned->format('m/d/y h:i a') : 'Unreturned' }}
                            </td>
                            <td>₱{{ $borrower->fine }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- @include('modals.book.new_rfid') --}}
@endsection
