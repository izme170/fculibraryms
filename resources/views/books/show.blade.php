@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    <div class="row">
        <div class="col" style="max-width: fit-content">
            <form action="/book/update-image/{{ $book->book_id }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <label for="book_image" style="cursor: pointer;">
                    <img class="img-thumbnail img-fluid"
                        src="{{ $book->book_image ? asset('storage/' . $book->book_image) : asset('img/default-book-image.png') }}"
                        alt="Book Image" id="book-image-preview" width="250px">
                </label>
                <input type="file" id="book_image" name="book_image" accept="image/*" style="display: none"
                    onchange="previewImage(this)">
                <button type="submit" style="display: none;" id="submit-button">Update Image</button>
            </form>
        </div>
        <div class="col">
            <div class="row">
                <h1>{{ $book->title }}</h1>
                <div class="mb-3">
                    @php
                        $availableCount = $book->bookCopies->where('status', 'Available')->count();
                        $borrowedCount = $book->bookCopies->where('status', 'Borrowed')->count();
                        $overdueCount = $book->bookCopies->where('status', 'Overdue')->count();
                    @endphp

                    @if ($availableCount > 0)
                        <span class="badge bg-success">Available: {{ $availableCount }}</span>
                    @endif
                    @if ($borrowedCount > 0)
                        <span class="badge bg-warning">Borrowed: {{ $borrowedCount }}</span>
                    @endif
                    @if ($overdueCount > 0)
                        <span class="badge bg-danger">Overdue: {{ $overdueCount }}</span>
                    @endif
                    {{-- <span class="badge {{ $book->status == 'available' ? 'bg-success' : 'bg-warning' }}">
                        {{ $book->status == 'available' ? 'Available' : 'Borrowed' }}
                    </span>
                    @if ($book->status == 'overdue')
                        <span class="badge bg-danger">Overdue</span>
                    @endif --}}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div><span class="text-secondary">Author/s: {!! $book->authors->map(
                            fn($author) => '<a class="text-decoration-none" href="/books/?search=' .
                                urlencode($author->name) .
                                '">' .
                                $author->name .
                                '</a>',
                        )->implode(', ') !!}</span></div>
                    <div><span class="text-secondary">Editor/s: {!! $book->editors->map(
                            fn($editor) => '<a class="text-decoration-none" href="/books/?search=' .
                                urlencode($editor->name) .
                                '">' .
                                $editor->name .
                                '</a>',
                        )->implode(', ') !!}</span></div>
                    <div><span class="text-secondary">Illustrator/s: {!! $book->illustrators->map(
                            fn($illustrator) => '<a class="text-decoration-none" href="/books/?search=' .
                                urlencode($illustrator->name) .
                                '">' .
                                $illustrator->name .
                                '</a>',
                        )->implode(', ') !!}</span></div>
                    <div><span class="text-secondary">Subject/s: {!! $book->subjects->map(
                            fn($subject) => '<a class="text-decoration-none" href="/books/?search=' .
                                urlencode($subject->name) .
                                '">' .
                                $subject->name .
                                '</a>',
                        )->implode(', ') !!}</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div><span class="fw-bold">ISBN: </span>{{ $book->isbn }}</div>
            <div><span class="fw-bold">Publisher: </span>{{ $book->publisher }}</div>
            <div><span class="fw-bold">Publication Date: </span>{{ $book->publication_date }}</div>
            <div><span class="fw-bold">Category: </span><a class="text-decoration-none"
                href="/books/?category={{ $book->category_id }}">{{ $book->category->category }}</a></div>
        </div>
        <div class="col">
            <div><span class="fw-bold">Edition: </span>{{ $book->edition }}</div>
            <div><span class="fw-bold">Volume: </span>{{ $book->volume }}</div>
            <div><span class="fw-bold">Pages: </span>{{ $book->pages }}</div>
        </div>
        <div class="col">
            <div class="row"><span class="fw-bold">Description: </span></div>
            <div class="row"><span>{{ $book->description }}</span></div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex gap-1 mb-3">
            <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#editBook">Update</button>
            <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#archiveBook">Archive</button>
            {{-- <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#newBookRFID">Assign new
                RFID</button> --}}
        </div>
    </div>
    <div class="row">
        <span class="fs-4 fw-bold">Copies: {{$book->bookCopies->count() }}</span>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Copy No.</th>
                    <th scope="col">Call No.</th>
                    <th scope="col">Accession No.</th>
                    <th scope="col">RFID</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($book->bookCopies as $copy)
                    <tr onclick="location.href='/show-copy/{{ $copy->copy_id}}'" style="cursor: pointer;">
                        <td>{{ $copy->copy_number }}</td>
                        <td>{{ $copy->call_number }}</td>
                        <td>{{ $copy->accession_number }}</td>
                        <td>{{ $copy->rfid }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <div class="row">
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
    </div> --}}
    {{-- <div class="bg-white p-3 rounded d-flex gap-3 flex-wrap justify-content-center" style="min-width: fit-content">
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
            <div>Author/s: {!! $book->authors->map(fn($author) => '<a class="text-decoration-none" href="/books/?search='.urlencode($author->name).'">'.$author->name.'</a>')->implode(', ') !!}</div>
            <div>Accession Number: {{ $book->accession_number }}</div>
            <div>ISBN: {{ $book->isbn }}</div>
            <div>Call Number: {{ $book->call_number }}</div>
            <div>Publisher: {{ $book->publisher }}</div>
            <div>Publication Date: {{ $book->publication_date }}</div>
            <div>Edition: {{$book->edition}}</div>
            <div>Volume: {{ $book->volume }}</div>
            <div>Pages: {{ $book->pages}}</div>
            <div>Category: {{ $book->category->category }}</div>
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
    </div> --}}
    @include('modals.book.edit')
    @include('modals.book.archive')
    {{-- @include('modals.book.new_rfid') --}}
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
