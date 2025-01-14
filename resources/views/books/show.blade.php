@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <div class="bg-white p-3 rounded d-flex gap-3 flex-wrap justify-content-center" style="min-width: fit-content">
        <div>
            <img src="{{ asset('img/default-book-cover.png') }}" class="img-thumbnail img-fluid" alt="..." width="200px">
        </div>
        <div>
            <h1>{{ $book->title }}</h1>
            <p>Author: {{ $book->author }}</p>
            <p>Category: {{ $book->category->category }}</p>
            <div class="mb-3">
                <span class="badge {{ $book->status == 'available' ? 'bg-success' : 'bg-warning' }}">
                    {{ $book->status == 'available' ? 'Available' : 'Borrowed' }}
                </span>
                @if ($book->status == 'overdue')
                    <span class="badge bg-danger">Overdue</span>
                @endif
            </div>

            <div class="d-flex gap-1 mb-3">
                <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#editBook">Update</button>
                <button class="btn-simple" type="button" data-bs-toggle="modal"
                    data-bs-target="#archiveBook">Archive</button>
                <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#newBookRFID">Assign new
                    RFID</button>
                {{-- <a class="text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#editBook" style="color: #0E1133">
                    <x-lucide-edit class="icon" />Update
                </a>
                <a class="text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#archiveBook" style="color: #0E1133">
                    <x-lucide-archive class="icon" />Archive
                </a>
                <a class="text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#newBookRFID" style="color: #0E1133">
                    <x-lucide-radio class="icon" />Assign new RFID
                </a> --}}
            </div>

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
                        @foreach ($previous_borrowers as $borrower)
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
    </div>
    @include('modals.book.edit')
    @include('modals.book.archive')
    @include('modals.book.new_rfid')

    @include('include.messages')
@endsection
