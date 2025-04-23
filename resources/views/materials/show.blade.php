@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    <div class="bg-white p-3 rounded" style="min-width: fit-content">
        <a href="{{ route('materials.index') }}" class="text-decoration-none text-dark">
            <x-lucide-arrow-left width="30" class="mb-2" />
        </a>
        <div class="row">
            <div class="col" style="max-width: fit-content">
                <form action="/material/update-image/{{ $material->material_id }}" method="post"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <label for="material_image" style="cursor: pointer;">
                        <img class="img-thumbnail img-fluid"
                            src="{{ $material->material_image ? asset('storage/' . $material->material_image) : asset('img/default-material-image.png') }}"
                            alt="Material Image" id="material-image-preview" width="250px">
                    </label>
                    <input type="file" id="material_image" name="material_image" accept="image/*" style="display: none"
                        onchange="previewImage(this)">
                    <button type="submit" style="display: none;" id="submit-button">Update Image</button>
                </form>
            </div>
            <div class="col">
                <div class="row">
                    <h1>{{ $material->title }}</h1>
                    <div class="mb-3">
                        @php
                            $availableCount = $material->materialCopies->where('status', 'Available')->count();
                            $borrowedCount = $material->materialCopies->where('status', 'Borrowed')->count();
                            $overdueCount = $material->materialCopies->where('status', 'Overdue')->count();
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
                        {{-- <span class="badge {{ $material->status == 'available' ? 'bg-success' : 'bg-warning' }}">
                        {{ $material->status == 'available' ? 'Available' : 'Borrowed' }}
                    </span>
                    @if ($material->status == 'overdue')
                        <span class="badge bg-danger">Overdue</span>
                    @endif --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div><span class="text-secondary">Author/s: @if ($material->authors->count() > 0)
                                    {!! $material->authors->map(
                                            fn($author) => '<a class="text-decoration-none" href="/materials/?search=' .
                                                urlencode($author->name) .
                                                '">' .
                                                $author->name .
                                                '</a>',
                                        )->implode(', ') !!}
                                @else
                                    None
                                @endif
                            </span>
                        </div>
                        <div><span class="text-secondary">Editor/s: @if ($material->editors->count() > 0)
                                    {!! $material->editors->map(
                                            fn($editor) => '<a class="text-decoration-none" href="/materials/?search=' .
                                                urlencode($editor->name) .
                                                '">' .
                                                $editor->name .
                                                '</a>',
                                        )->implode(', ') !!}
                                @else
                                    None
                                @endif
                            </span>
                        </div>
                        <div><span class="text-secondary">Illustrator/s: @if ($material->illustrators->count() > 0)
                                    {!! $material->illustrators->map(
                                            fn($illustrator) => '<a class="text-decoration-none" href="/materials/?search=' .
                                                urlencode($illustrator->name) .
                                                '">' .
                                                $illustrator->name .
                                                '</a>',
                                        )->implode(', ') !!}
                                @else
                                    None
                                @endif
                            </span>
                        </div>
                        <div><span class="text-secondary">Translator/s: @if ($material->translators->count() > 0)
                                    {!! $material->translators->map(
                                            fn($translator) => '<a class="text-decoration-none" href="/materials/?search=' .
                                                urlencode($translator->name) .
                                                '">' .
                                                $translator->name .
                                                '</a>',
                                        )->implode(', ') !!}
                                @else
                                    None
                                @endif
                            </span>
                        </div>
                        <div><span class="text-secondary">Subject/s: @if ($material->subjects->count() > 0)
                                    {!! $material->subjects->map(
                                            fn($subject) => '<a class="text-decoration-none" href="/materials/?search=' .
                                                urlencode($subject->subject) .
                                                '">' .
                                                $subject->name .
                                                '</a>',
                                        )->implode(', ') !!}
                                @else
                                    None
                                @endif
                            </span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div><span class="fw-bold">ISBN: </span>{{ $material->isbn ?? 'None' }}</div>
                <div><span class="fw-bold">ISSN: </span>{{ $material->issn ?? 'None' }}</div>
                <div><span class="fw-bold">Publisher: </span>{{ $material->publisher->name ?? 'None' }}</div>
                <div><span class="fw-bold">Publication Year: </span>{{ $material->publication_year ?? 'None' }}</div>
                <div><span class="fw-bold">Edition: </span>{{ $material->edition ?? 'None' }}</div>

            </div>
            <div class="col">
                <div><span class="fw-bold">Volume: </span>{{ $material->volume ?? 'None' }}</div>
                <div><span class="fw-bold">Pages: </span>{{ $material->pages ?? 'None' }}</div>
                <div><span class="fw-bold">Includes: </span>{{ $material->includes ?? 'None' }}</div>
                <div><span class="fw-bold">Size: </span>{{ $material->size ?? 'None' }}</div>
                <div><span class="fw-bold">Category: </span>
                    @if ($material->category)
                        <a class="text-decoration-none" href="/materials/?search={{ $material->category->category }}">
                            {{ $material->category->category }}
                        </a>
                    @else
                        None
                    @endif
                </div>
            </div>
            <div class="col">
                <div class="row"><span class="fw-bold">Description: </span></div>
                <div class="row"><span>{{ $material->description ?? 'None' }}</span></div>
            </div>
        </div>
        <div class="row border-bottom mb-3">
            <div class="d-flex gap-1 mb-3">
                <button class="btn-simple" type="button" data-bs-toggle="modal"
                    data-bs-target="#editMaterial">Update</button>
                @if (!$material->is_archived)
                    <button class="btn-simple" type="button" data-bs-toggle="modal"
                        data-bs-target="#archiveMaterial">Archive</button>
                @else
                    <a class="btn-simple" href="/material/unarchive/{{ $material->material_id }}">Unarchive</a>
                @endif
                <a class="btn-simple" href="/create-copy/{{ $material->material_id }}">Add Copy</a>
                {{-- <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#newMaterialRFID">Assign new
                RFID</button> --}}
            </div>
        </div>
        <div class="row">
            <span class="fs-4 fw-bold">Copies: {{ $material->materialCopies->count() }}</span>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Copy No.</th>
                        <th scope="col">Call No.</th>
                        <th scope="col">Accession No.</th>
                        <th scope="col">RFID</th>
                        <th scope="col">Condition</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($material->materialCopies as $copy)
                        <tr onclick="location.href='/copy/show/{{ $copy->copy_id }}'" style="cursor: pointer;">
                            <td>{{ $copy->copy_number }}</td>
                            <td>{{ $copy->call_number }}</td>
                            <td>{{ $copy->accession_number }}</td>
                            <td>{{ $copy->rfid }}</td>
                            <td>{{ $copy->condition->name ?? 'Not specified' }}</td>
                            @if ($copy->status == 'Available')
                                <td><span class="badge bg-success">Available</span></td>
                            @elseif ($copy->status == 'Borrowed')
                                <td><span class="badge bg-warning">Borrowed</span></td>
                            @elseif ($copy->status == 'Overdue')
                                <td><span class="badge bg-danger">Overdue</span></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('modals.material.edit')
    @include('modals.material.archive')
    {{-- @include('modals.material.new_rfid') --}}

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const preview = document.getElementById('material-image-preview');

            reader.onload = function() {
                preview.src = reader.result;
            };

            reader.readAsDataURL(event.files[0]);

            document.getElementById('submit-button').click();
        }
    </script>
@endsection
