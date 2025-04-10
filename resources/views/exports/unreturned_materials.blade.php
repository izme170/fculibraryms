<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Department</th>
            <th>Patron</th>
            <th>Material Type</th>
            <th>Title</th>
            <th>Fine</th>
            <th>Contact #</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($unreturned_materials as $data)
            <tr>
                <td>{{ $data->created_at->format('d/m/y') }}</td>
                <td>{{ $data->patron->type->type }}</td>
                <td>{{ $data->patron->department->departmentAcronym ?? '' }}</td>
                <td>{{ $data->patron->fullname }}</td>
                <td>{{ $data->materialCopy->material->materialType->name }}</td>
                <td>{{ $data->materialCopy->material->title }}</td>
                <td>₱{{ $data->fine }}</td>
                <td>{{ $data->patron->contact_number }}</td>
            </tr>
        @endforeach
    </tbody>
</table>