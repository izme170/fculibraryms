@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    @vite('resources/js/app.js')
    @include('include.report_tabs')
    <div class="bg-white p-3 rounded" style="min-width: fit-content">
        <form action="/reports" method="GET">
            <div class="d-flex gap-3" style="width: 500px">
                <select name="year">
                    @for ($y = date('Y'); $y >= 2000; $y--)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}
                        </option>
                    @endfor
                </select>
                <select name="month">
                    <option value="">Select Month (for daily)</option>
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                    @endfor
                </select>
                <input type="number" name="limit" value="{{ $limit }}" placeholder="Limit" />
                <button type="submit" class="btn-simple">Apply</button>
            </div>
        </form>

        <h3 class="mb-3 mt-4">Top Library Users</h3>
        <button class="btn-simple" id="exportTopUser"
            onclick='exportChart("top-library-users", @json($patronNames), @json($loginCounts), "top-users")'>
            Export to PDF
        </button>
        <div class="chart-container" style="position: relative; width:600px; margin: 0 auto;">
            <canvas id="top-users"></canvas>
        </div>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patron Name</th>
                    <th>Logins</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patronNames as $index => $name)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $name }}</td>
                        <td>{{ $loginCounts[$index] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Top Marketers --}}
        <h3 class="mb-3 mt-4">Top Marketers</h3>
        <button class="btn-simple" id="exportTopMarketers"
            onclick='exportChart("top-marketers", @json($marketerNames), @json($marketerCounts), "top-marketers")'>
            Export to PDF
        </button>
        <div class="chart-container" style="position: relative; width:600px; margin: 0 auto;">
            <canvas id="top-marketers"></canvas>
        </div>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Marketer Name</th>
                    <th>Logins</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($marketerNames as $index => $name)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $name }}</td>
                        <td>{{ $marketerCounts[$index] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Top Departments --}}
        <h3 class="mb-3 mt-4">Top Departments</h3>
        <button class="btn-simple" id="exportTopDepartments"
            onclick='exportChart("top-departments", @json($departmentNames), @json($departmentCounts), "top-departments")'>
            Export to PDF
        </button>
        <div class="chart-container" style="position: relative; width:600px; margin: 0 auto;">
            <canvas id="top-departments"></canvas>
        </div>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Department Name</th>
                    <th>Logins</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departmentNames as $index => $name)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $name }}</td>
                        <td>{{ $departmentCounts[$index] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function exportChart(routeName, labels, values, chartId) {
            const chartElement = Chart.getChart(chartId); // Get the Chart.js instance
            if (!chartElement) {
                console.error(`Chart with id "${chartId}" not found.`);
                return;
            }

            const chartImage = chartElement.toBase64Image(); // Get the base64-encoded image

            // Send the chart image and table data to the server
            const formData = new FormData();
            formData.append('labels', JSON.stringify(labels));
            formData.append('values', JSON.stringify(values));
            formData.append('chartImage', chartImage);

            fetch(`/reports/export/${routeName}`, { // Corrected URL construction
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token for security
                    },
                })
                .catch((error) => console.error('Error exporting chart and table:', error));
        }


        var data = @json($loginCounts);
        var labels = @json($patronNames);
        document.addEventListener('DOMContentLoaded', () => {
            var ctx = document.getElementById('top-users').getContext('2d');
            var topLibraryUser = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Logins',
                        data: data,
                        backgroundColor: 'rgba(244, 67, 54, 0.2)',
                        borderColor: 'rgba(233, 30, 99, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'Top Library User'
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return Number.isInteger(value) ? value : null;
                                },
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });

        var data1 = @json($marketerCounts);
        var labels1 = @json($marketerNames);
        document.addEventListener('DOMContentLoaded', () => {
            var ctx = document.getElementById('top-marketers').getContext('2d');
            var topMarketers = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels1,
                    datasets: [{
                        label: 'Marketer',
                        data: data1,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'Top Marketers'
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return Number.isInteger(value) ? value : null;
                                },
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });

        var data2 = @json($departmentCounts);
        var labels2 = @json($departmentNames);
        document.addEventListener('DOMContentLoaded', () => {
            var ctx = document.getElementById('top-departments').getContext('2d');
            var topDepartments = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels2,
                    datasets: [{
                        label: 'Logins',
                        data: data2,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'Top Departments'
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return Number.isInteger(value) ? value : null;
                                },
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
