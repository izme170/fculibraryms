@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <a class="btn-simple" href="/borrow-book">Borrow Book</a>
    <a class="btn-simple" href="/return-book">Return Book</a>

    <div class="widget-container">
        <div class="widget">
            <div class="w-text small">
                Total visits today:
            </div>
            <div class="w-text large">
                {{ $total_visits_today }}
            </div>
        </div>

        <div class="widget">
            <div class="w-text small">
                Unreturned Books:
            </div>
            <div class="w-text large">
                {{ $total_unreturned_books }}
            </div>
        </div>
    </div>

    <div class="chart-container" style="position: relative; width:50vw">
        <canvas id="dailyVisitChart"></canvas>
    </div>

    <script>
        var data = @json($visits);
        console.log(data);
        document.addEventListener('DOMContentLoaded', () => {
            var ctx = document.getElementById('dailyVisitChart').getContext('2d');
            var dailyVisitChart = new Chart(ctx, {
                type: 'bar',
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
                            beginAtZero: true,
                            ticks: {
                                // Only display whole numbers
                                callback: function(value, index, values) {
                                    return Number.isInteger(value) ? value : null;
                                },
                                stepSize: 1 // Ensure the ticks increment by 1
                            }
                        }
                    },
                }
            });
        });
    </script>
@endsection
