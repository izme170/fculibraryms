@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <div class="widget">
        <a class="btn-simple" href="/borrow-book">Borrow Book</a>
        <a class="btn-simple" href="/return-book">Return Book</a>
    </div>

    <div class="row">
        <div class="col">
            <div class="widget">
                <div class="w-text small">
                    Total visits today: {{ $visits_today }}
                </div>
                <div class="chart-container" style="position: relative; width:600px">
                    <canvas id="dailyVisitChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="widget">
                <div class="w-text small" id="datetime"></div>
            </div>
            <div class="widget">
                <div class="w-text small">
                    Unreturned Books: {{ count($unreturned_books_list) }}
                </div>
                @foreach ($unreturned_books_list as $book)
                    <div class="w-text">{{ $book->title }}</div>
                @endforeach
            </div>
        </div>
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
                            'rgb(14, 17, 51)',
                        ],
                        borderRadius: 5
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'Visits of the Week',
                            color: 'rgb(14, 17, 51)',
                            font: {
                                size: 25
                            }
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

        //Date and time
        function updateDateTime() {
            const now = new Date(); // Get the current date and time

            // Format the date and time
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            };
            const currentDateTime = now.toLocaleString('en-US', options); // Use locale for formatting

            // Display date and time in the div
            document.getElementById('datetime').textContent = currentDateTime;
        }

        setInterval(updateDateTime, 1000); // Update every second
        updateDateTime(); // Initial call to display date and time right away
    </script>
@endsection
