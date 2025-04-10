<table>
    <thead>
        <tr>
            <th>Department</th>
            @for ($month = 1; $month <= 12; $month++)
                <th>{{ date('M', mktime(0, 0, 0, $month, 10)) }}</th>
            @endfor
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reportData as $department => $row)
            <tr>
                <td>{{ $department }}</td>
                @for ($month = 1; $month <= 12; $month++)
                    <td>{{ $row[$month] ?? 0 }}</td>
                @endfor
                <td>{{ $rowTotals[$department] ?? 0 }}</td>
            </tr>
        @endforeach
        <tr>
            <td>Total</td>
            @for ($month = 1; $month <= 12; $month++)
                <td>{{ $monthlyTotals[$month] ?? 0 }}</td>
            @endfor
            <td>{{ $grandTotal ?? 0 }}</td>
        </tr>
    </tbody>
</table>