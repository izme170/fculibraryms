@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    <div class="bg-white p-3 roundedstyle="min-width: fit-content">
        <a href="{{ route('users.index') }}" class="text-decoration-none text-dark">
            <x-lucide-arrow-left width="30" />
        </a>
        <div class="d-flex gap-3 flex-wrap justify-content-center">
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
                    <button class="btn-simple" type="button" data-bs-toggle="modal"
                        data-bs-target="#editUser">Update</button>
                    <button class="btn-simple" type="button" data-bs-toggle="modal"
                        data-bs-target="#toggleArchiveUser">{{ $user->is_archived ? 'Restore' : 'Archive' }}</button>
                    {{-- Don't show the toggle user status button if the user is archived --}}
                    @if (!$user->is_archived)
                        <button class="btn-simple {{ $user->is_active ? 'bg-danger' : 'bg-success' }}" type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#toggleUserStatus">{{ $user->is_active ? 'Deactivate' : 'Activate' }}</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('modals.user.edit')
    @include('modals.user.toggle_archive')
    @include('modals.user.toggle_status')

    <script>
        function previewImage(input) {
            var file = input.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function() {
                    document.getElementById('image-preview').src = reader.result;
                }
                reader.readAsDataURL(file);

                document.getElementById('submit-button').click();
            }
        }
    </script>
@endsection
