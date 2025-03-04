@extends('layout.main')
@include('include.sidenav')
@section('user-content')
@include('include.topbar')
    <div class="bg-white p-3 rounded d-flex gap-3 flex-wrap flex-column justify-content-center"
        style="min-width: fit-content">
        <div class="d-flex gap-3 flex-row justify-content-start">
            <div>
                <form action="/patron/update-image/{{ $patron->patron_id }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <label for="patron_image" style="cursor: pointer;">
                        <img class="img-thumbnail img-fluid"
                            src="{{ $patron->patron_image ? asset('storage/' . $patron->patron_image) : asset('img/default-patron-image.png') }}"
                            alt="Patron Image" id="image-preview" width="200px">
                    </label>
                    <input type="file" id="patron_image" name="patron_image" accept="image/*" style="display: none"
                        onchange="previewImage(this)">
                    <button type="submit" style="display: none;" id="submit-button">Update Image</button>
                </form>
                <h2>{{ $patron->first_name }} {{ $patron->middle_name }} {{ $patron->last_name }}</h2>
            </div>
            <div class="grid">
                <div class="row">
                    <div class="col">
                        <div class="row mb-1">
                            <p><strong>Patron Type:</strong> {{ $patron->type->type }}</p>
                        </div>
                        @if ($patron->department)
                            <div class="row mb-1">
                                <p><strong>Department:</strong> {{ $patron->department->department }}</p>
                            </div>
                        @endif
                        @if ($patron->course)
                            <div class="row mb-1">
                                <p><strong>Course:</strong> {{ $patron->course->course }}</p>
                            </div>
                        @endif
                        @if ($patron->contact_number)
                            <div class="row mb-1">
                                <p><strong>Contact Number:</strong> {{ $patron->contact_number }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="col">
                        @if ($patron->email)
                            <div class="row mb-1">
                                <p><strong>Email:</strong> {{ $patron->email }}</p>
                            </div>
                        @endif
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
            <h5>Materials borrowed</h5>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Material</th>
                        <th scope="col">Date Returned</th>
                        <th scope="col">Fine</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrowed_materials as $borrowed_material)
                        <tr>
                            <td>{{ $borrowed_material->created_at->format('m/d/y h:i a') }}</td>
                            <td>{{ $borrowed_material->material->title }}</td>
                            <td>{{ $borrowed_material->returned ? $borrowed_material->returned->format('m/d/y h:i a') : 'Unreturned' }}
                            </td>
                            <td>₱{{ $borrowed_material->fine }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('modals.patron.edit')
    @include('modals.patron.archive')
    @include('modals.patron.new_rfid')

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const preview = document.getElementById('image-preview');

            reader.onload = function() {
                preview.src = reader.result;
            };

            reader.readAsDataURL(event.files[0]);

            document.getElementById('submit-button').click();
        }
    </script>
@endsection
