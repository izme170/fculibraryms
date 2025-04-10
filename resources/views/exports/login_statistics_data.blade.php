<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Department</th>
            <th>Patron</th>
            <th>Purpose</th>
            <th>Marketer</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($patron_logins as $patron_login)
            <tr>
                <td>{{ $patron_login->login_at->format('d/m/Y') }}</td>
                <td>{{ $patron_login->patron->type->type ?? 'N/A' }}</td>
                <td>{{ $patron_login->patron->department->departmentAcronym ?? 'N/A' }}</td>
                <td>{{ $patron_login->patron->first_name . ' ' . $patron_login->patron->last_name }}</td>
                <td>{{ $patron_login->purpose->purpose ?? 'Not indicated' }}</td>
                <td>{{ $patron_login->marketer->marketer ?? 'None' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>