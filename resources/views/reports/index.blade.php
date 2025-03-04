@extends('layout.main')
@include('include.sidenav')
@section('user-content')
@include('include.topbar')
    @vite('resources/js/app.js')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/reports">Daily Visit</a>
        </li>
        <li class="nav-item bg-secondary rounded-top">
            <a class="nav-link text-black" href="/monthly-login">Monthly Visit</a>
        </li>
        <li class="nav-item bg-secondary rounded-top">
            <a class="nav-link text-black" href="/monthly-login">Yearly Visit</a>
        </li>
        <li class="nav-item bg-secondary rounded-top">
            <a class="nav-link text-black" href="/monthly-login">Daily Materials Borrowed</a>
        </li>
        <li class="nav-item bg-secondary rounded-top">
            <a class="nav-link text-black" href="/monthly-login">Monthly Materials Borrowed</a>
        </li>
        <li class="nav-item bg-secondary rounded-top">
            <a class="nav-link text-black" href="/monthly-login">Yearly Materials Borrowed</a>
        </li>
    </ul>

    <div class="container">
        <div class="chart-container" style="position: relative; width:500px;">
            <canvas id="topLibraryUser"></canvas>
        </div>
    </div>
    <div class="container">
        <div class="chart-container" style="position: relative; width:500px;">
            <canvas id="topMarketers"></canvas>
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
                            text: 'Top Library User'
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                // Only display whole numbers
                                callback: function(value, index, values) {
                                    return Number.isInteger(value) ? value : null;
                                },
                                stepSize: 1 // Ensure the ticks increment by 1
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
                                // Only display whole numbers
                                callback: function(value, index, values) {
                                    return Number.isInteger(value) ? value : null;
                                },
                                stepSize: 1 // Ensure the ticks increment by 1
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
