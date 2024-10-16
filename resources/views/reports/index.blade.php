@extends('layout.main')
@include('include.sidenav')
@section('user-content')
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
            <a class="nav-link text-black" href="/monthly-login">Daily Books Borrowed</a>
        </li>
        <li class="nav-item bg-secondary rounded-top">
            <a class="nav-link text-black" href="/monthly-login">Monthly Books Borrowed</a>
        </li>
        <li class="nav-item bg-secondary rounded-top">
            <a class="nav-link text-black" href="/monthly-login">Yearly Books Borrowed</a>
        </li>
    </ul>

    <div class="container">
        <div class="chart-container" style="position: relative; width:10em;">
            <canvas id="dailyVisitChart"></canvas>
        </div>
    </div>

        <script>
            var data = [1, 1, 1, 1, 1, 1, 1];
            console.log(data);
            document.addEventListener('DOMContentLoaded', () => {
                var ctx = document.getElementById('dailyVisitChart').getContext('2d');
                var dailyVisitChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                        datasets: [{
                            data: data,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: false,
                            },
                            title: {
                                display: true,
                                text: 'Total Visits'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
@endsection
