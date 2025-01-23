@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <div class="bg-white p-3 rounded d-flex gap-3 flex-wrap justify-content-center" style="min-width: fit-content">
        <div>
            <form action="/user/update-image/{{ $user->user_id }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <label for="user_image" style="cursor: pointer;">
                    <img class="img-thumbnail img-fluid"
                        src="{{ $user->user_image ? asset('storage/' . $user->user_image) : asset('img/default-user-image.png') }}"
                        alt="User Image" id="image-preview" width="200px">
                </label>
                <input type="file" id="user_image" name="user_image" accept="image/*" style="display: none"
                    onchange="previewImage(this)">
                <button type="submit" style="display: none;" id="submit-button">Update Image</button>
            </form>
        </div>
        <div>
            <h1>{{ $user->first_name . ' ' . $user->last_name }}</h1>
            <p>{{ $user->role->role }}</p>
            <p>Contact Number: {{ $user->contact_number }}</p>
            <p>Email: {{ $user->email }}</p>
            <p>username: {{ $user->username }}</p>
            <div class="mb-3">
                <button class="btn-simple" type="button" data-bs-toggle="modal" data-bs-target="#editUser">Update</button>
                <button class="btn-simple" type="button" data-bs-toggle="modal"
                    data-bs-target="#archiveUser">Archive</button>
                @if ($user->is_active)
                    <button class="btn-simple bg-danger" type="button" data-bs-toggle="modal"
                        data-bs-target="#deactivate">Deactivate</button>
                @else
                    <button class="btn-simple bg-success" type="button" data-bs-toggle="modal"
                        data-bs-target="#activate">Activate</button>
                @endif

            </div>
        </div>
    </div>
    @include('modals.user.edit')
    @include('modals.user.archive')
    @include('modals.user.deactivate')
    @include('modals.user.activate')

    <script>
        function previewImage(input) {
            var file = input.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function () {
                    document.getElementById('image-preview').src = reader.result;
                }
                reader.readAsDataURL(file);

                document.getElementById('submit-button').click();
            }
        }
    </script>
@endsection
