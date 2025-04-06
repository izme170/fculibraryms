<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .chart-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>

    {{-- Include the Chart --}}
    @if (!empty($chartImage))
        <div class="chart-container">
            <img src="{{ $chartImage }}" alt="Chart" style="max-width: 100%; height: auto;">
        </div>
    @endif

    {{-- Include the Table --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Logins</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($labels as $index => $label)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $label }}</td>
                    <td>{{ $values[$index] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>