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
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <select name="month">
                    <option value="">Select Month (for daily)</option>
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn-simple">Apply</button>
            </div>
        </form>
        <div class="d-flex justify-content-evenly">
            <div class="chart-container" style="position: relative; width:500px;">
                <canvas id="topLibraryUser"></canvas>
            </div>
            <div class="chart-container" style="position: relative; width:500px;">
                <canvas id="topMarketers"></canvas>
            </div>
        </div>
        <div class="chart-container mt-4" style="position: relative; width:600px; margin: 0 auto;">
            <canvas id="topDepartments"></canvas>
        </div>
    </div>

    <script>
        var data = @json($loginCounts);
        var labels = @json($patronNames);
        document.addEventListener('DOMContentLoaded', () => {
            var ctx = document.getElementById('topLibraryUser').getContext('2d');
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
            var ctx = document.getElementById('topMarketers').getContext('2d');
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
            var ctx = document.getElementById('topDepartments').getContext('2d');
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
