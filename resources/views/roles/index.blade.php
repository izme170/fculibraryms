@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/users">Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="/roles">Roles</a>
        </li>
    </ul>
    <form action="/role/store" method="post">
        @csrf
        <div class="d-flex w-50">
            <input type="text" name="role" placeholder="Add role here..." required>
            <button type="submit" class="btn-simple">Add</button>
        </div>
    </form>
    <form action="/roles/update" method="post">
        @csrf
        @method('PUT')
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Role</th>
                    <th scope="col">Book Management</th>
                    <th scope="col">Patron Management</th>
                    <th scope="col">Reports</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->role }}</td>
                        <td>
                            <input type="checkbox" class="form-check-input" name="roles{{ $role->id }}[books_access]"
                                   {{ $role->books_access ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="checkbox" class="form-check-input" name="roles{{ $role->id }}[patrons_access]"
                                   {{ $role->patrons_access ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="checkbox" class="form-check-input" name="roles{{ $role->id }}[reports_access]"
                                   {{ $role->reports_access ? 'checked' : '' }}>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button class="btn-simple" type="submit">Save</button>
    </form>
@endsection
