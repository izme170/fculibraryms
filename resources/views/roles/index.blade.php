@extends('layout.main')
@include('include.sidenav')
@section('user-content')
@include('include.topbar')
@include('include.user_tabs')
    <link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
    <div class="container">
        <form action="/role/store" method="post">
            @csrf
            <div class="d-flex w-50 mt-3">
                <input type="text" name="role" placeholder="Add role here..." required>
                <button type="submit" class="btn-add">Add</button>
            </div>
        </form>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Role</th>
                    <th scope="col">Material Management</th>
                    <th scope="col">Patron Management</th>
                    <th scope="col">Reports</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <form action="/role/update/{{ $role->role_id }}" method="post" class="role-form">
                            @csrf
                            @method('PUT')
                            <td>{{ $role->role }}</td>
                            <td>
                                <label class="switch">
                                    <div class="toggle-switch">
                                        <input type="checkbox" id="materials_access{{ $role->role_id }}" name="materials_access"
                                            {{ $role->materials_access ? 'checked' : '' }} disabled>
                                        <label for="materials_access{{ $role->role_id }}"></label>
                                    </div>
                                </label>
                            </td>
                            <td>
                                <label class="switch">
                                    <div class="toggle-switch">
                                        <input type="checkbox" id="patrons_access{{ $role->role_id }}" name="patrons_access"
                                            {{ $role->patrons_access ? 'checked' : '' }} disabled>
                                        <label for="patrons_access{{ $role->role_id }}"></label>
                                    </div>
                                </label>
                            </td>
                            <td>
                                <label class="switch">
                                    <div class="toggle-switch">
                                        <input type="checkbox" id="reports_access{{ $role->role_id }}" name="reports_access"
                                            {{ $role->reports_access ? 'checked' : '' }} disabled>
                                        <label for="reports_access{{ $role->role_id }}"></label>
                                    </div>
                                </label>
                            </td>
                            <td>
                                <button class="btn-simple edit-btn" type="button">Edit</button>
                                <button class="btn-simple cancel-btn" type="button" hidden onclick="location.reload();">Cancel</button>
                                <button class="btn-simple save-btn" type="submit" hidden>Save</button>
                            </td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-btn');
            const saveButtons = document.querySelectorAll('.save-btn');
            const cancelButtons = document.querySelectorAll('.cancel-btn');

            editButtons.forEach((editBtn, index) => {
                editBtn.addEventListener('click', function() {
                    // Hide all edit buttons
                    editButtons.forEach((btn) => {
                        btn.hidden = true;
                    });

                    const row = editBtn.closest('tr');
                    const checkboxes = row.querySelectorAll('input[type="checkbox"]');

                    // Enable checkboxes
                    checkboxes.forEach(checkbox => {
                        checkbox.disabled = false;
                    });

                    // Show Save and Cancel buttons for the current row
                    saveButtons[index].hidden = false;
                    cancelButtons[index].hidden = false;
                });
            });

            saveButtons.forEach((saveBtn, index) => {
                saveBtn.addEventListener('click', function() {
                    const row = saveBtn.closest('tr');
                    const checkboxes = row.querySelectorAll('input[type="checkbox"]');

                    // Log checkbox values
                    const data = {};
                    checkboxes.forEach(checkbox => {
                        data[checkbox.name] = checkbox.checked;
                    });
                    console.log(data); // Log the checkbox values

                    // Enable checkboxes before form submission
                    checkboxes.forEach(checkbox => {
                        checkbox.disabled = false;
                    });
                });
            });
        });
    </script>
@endsection
