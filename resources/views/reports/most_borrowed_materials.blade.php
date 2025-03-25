@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    @include('include.report_tabs')
    <div class="container">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Type</th>
                    <th scope="col">Department</th>
                    <th scope="col">Patron</th>
                    <th scope="col">Material Type</th>
                    <th scope="col">Title</th>
                    <th scope="col">Fine</th>
                    <th scope="col">Contact #</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($unreturned_materials as $data)
                    <tr>
                        <td>{{ $data->created_at->format('d/m/y') }}</td>
                        <td>{{ $data->patron->type->type }}</td>
                        <td>{{ $data->patron->department->departmentAcronym ?? '' }}</td>
                        <td><a class="shortcut-link"
                                href="/patron/show/{{ $data->patron_id }}">{{ $data->patron->fullname }}</a>
                        </td>
                        <td>{{ $data->materialCopy->material->materialType->name }}</td>
                        <td>{{ $data->materialCopy->material->title }}</td>
                        <td>₱{{ $data->fine }}</td>
                        <td>{{ $data->patron->contact_number }}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
