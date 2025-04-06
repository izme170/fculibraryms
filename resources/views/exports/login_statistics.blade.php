<table>
    <thead>
        <tr>
            <th>Department</th>
            @for ($day = 1; $day <= $daysInMonth; $day++)
                <th>{{ $day }}</th>
            @endfor
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reportData as $department => $row)
            <tr>
                <td>{{ $department }}</td>
                @for ($day = 1; $day <= $daysInMonth; $day++)
                    <td>{{ $row[$day] ?? 0 }}</td>
                @endfor
                <td>{{ $rowTotals[$department] ?? 0 }}</td>
            </tr>
        @endforeach
        <tr>
            <td>Total</td>
            @for ($day = 1; $day <= $daysInMonth; $day++)
                <td>{{ $dailyTotals[$day] ?? 0 }}</td>
            @endfor
            <td>{{ $grandTotal ?? 0 }}</td>
        </tr>
    </tbody>
</table>