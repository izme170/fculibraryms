@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <div class="bg-white p-3 rounded d-flex gap-3 flex-wrap flex-column justify-content-center"
        style="min-width: fit-content">
        <div class="d-flex gap-3 flex-row justify-content-start">
            <div>
                <img src="{{ asset('img/default-patron-image.png') }}" class="img-thumbnail img-fluid" alt="..."
                    width="200px">
                <h2>{{ $patron->first_name }} {{$patron->middle_name}} {{ $patron->last_name }}</h2>
            </div>
            <div class="grid">
                <div class="row">
                    <div class="col">
                        <div class="row mb-1">
                            <p><strong>Patron Type:</strong> {{ $patron->type->type }}</p>
                        </div>
                        <div class="row mb-1">
                            <p><strong>Department:</strong> {{ $patron->department->department }}</p>
                        </div>
                        <div class="row mb-1">
                            <p><strong>Course:</strong> {{ $patron->course->course }}</p>
                        </div>
                        <div class="row mb-1">
                            <p><strong>Contact</strong>{{ $patron->contact_number }}</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row mb-1">
                            <p><strong>Email:</strong> {{ $patron->email }}</p>
                        </div>
                        <div class="row mb-1">
                            <p><strong>Address:</strong> {{ $patron->address }}</p>
                        </div>
                        <div class="row mb-1">
                            <p><strong>RFID:</strong> {{ $patron->library_id }}</p>
                        </div>
                        @if ($patron->type->type === 'Student')
                        <div class="row">
                            <p><strong>Adviser:</strong> {{ $patron->adviser->adviser }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#editPatron">Update</button>
            <button class="btn-simple" type="button" data-bs-toggle="modal"
                data-bs-target="#archivePatron">Archive</button>
            <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#newPatronRFID">Assign new
                RFID</button>
        </div>
        <div>
            <h5>Books borrowed</h5>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Book</th>
                        <th scope="col">Date Returned</th>
                        <th scope="col">Fine</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrowed_books as $borrowed_book)
                        <tr>
                            <td>{{ $borrowed_book->created_at->format('m/d/y h:i a') }}</td>
                            <td>{{ $borrowed_book->book->title }}</td>
                            <td>{{ $borrowed_book->returned ? $borrowed_book->returned->format('m/d/y h:i a') : 'Unreturned' }}
                            </td>
                            <td>₱{{ $borrowed_book->fine }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('modals.patron.edit')
    @include('modals.patron.archive')
    @include('modals.patron.new_rfid')
@endsection
