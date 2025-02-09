@extends('layout.main')
@include('include.sidenav')
@section('user-content')
@include('include.topbar')
    <div class="bg-white p-3 rounded d-flex gap-3 flex-wrap justify-content-center" style="min-width: fit-content">
        <div>
            <form action="/book/update-image/{{ $book->book_id }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <label for="book_image" style="cursor: pointer;">
                    <img class="img-thumbnail img-fluid"
                        src="{{ $book->book_image ? asset('storage/' . $book->book_image) : asset('img/default-book-image.png') }}"
                        alt="Book Image" id="book-image-preview" width="200px">
                </label>
                <input type="file" id="book_image" name="book_image" accept="image/*" style="display: none"
                    onchange="previewImage(this)">
                <button type="submit" style="display: none;" id="submit-button">Update Image</button>
            </form>
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
@endsection

@section('script')
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const preview = document.getElementById('book-image-preview');

            reader.onload = function() {
                preview.src = reader.result;
            };

            reader.readAsDataURL(event.files[0]);

            document.getElementById('submit-button').click();
        }
    </script>
