@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    @vite('resources/js/app.js')
    <div class="col p-3">
        <div class="row mb-3">
            <div>
                <a class="btn-simple d-inline-flex align-items-center gap-1" href="/borrow-material"><x-fas-plus width="12" /> Borrow Material</a>
                <a class="btn-simple d-inline-flex align-items-center gap-1" href="/return-material"><x-fas-arrow-right width="12" /> Return Material</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="d-flex gap-3">
                @if (auth()->user()->role_id == 1)
                    <a href="{{ route('users.index') }}"
                        class="card w-25 shadow-sm rounded-3 bg-info-subtle border-0 text-decoration-none">
                        <div class="card-body d-flex align-items-center">
                            <x-fas-user-tie class="text-info me-3" width="50" />
                            <div>
                                <div class="fs-5 fw-bold text-info">Users</div>
                                <div class="fs-5 text-info"> {{ $user_count }} </div>
                            </div>
                        </div>
                    </a>
                @endif
                @if (auth()->user()->role->patrons_access)
                    <a href="{{ route('patrons.index') }}"
                        class="card w-25 shadow-sm rounded-3 bg-primary-subtle border-0 text-decoration-none">
                        <div class="card-body d-flex align-items-center">
                            <x-fas-user class="text-primary me-3" width="50" />
                            <div>
                                <div class="fs-5 fw-bold text-primary">Patrons</div>
                                <div class="fs-5 text-primary"> {{ $patron_count }} </div>
                            </div>
                        </div>
                    </a>
                @endif
                @if (auth()->user()->role->materials_access)
                    <a href="{{ route('materials.index') }}"
                        class="card w-25 shadow-sm rounded-3 bg-success-subtle border-0 text-decoration-none">
                        <div class="card-body d-flex align-items-center">
                            <x-fas-book class="text-success me-3" width="50" />
                            <div>
                                <div class="fs-5 fw-bold text-success">Materials</div>
                                <div class="fs-5 text-success"> {{ $material_count }} </div>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="widget-container">
                <div class="widget">
                    <div class="w-text small d-flex align-items-center gap-2">
                        <x-fas-user width="20" />
                        Visits today: {{ $visits_today }}
                    </div>
                    <div class="chart-container" style="position: relative; width:600px">
                        <canvas id="dailyVisitChart"></canvas>
                    </div>
                </div>
                <a class="shortcut" href="/patron-logins">Go to Patron Attendance</a>
            </div>
            <div class="widget-container">
                <div class="widget">
                    <div class="w-text small">
                        <span>{{ count($unreturnedMaterials) }} Unreturned Materials</span>
                    </div>
                    <ol>
                        @foreach ($unreturnedMaterials as $borrowedMaterial)
                            <li><a href="/material/show/{{ $borrowedMaterial->materialCopy->copy_id }}"
                                    class="shortcut-link">{{ $borrowedMaterial->materialCopy->material->title }}</a></li>
                        @endforeach
                    </ol>
                </div>
                <a href="/borrowed-materials" class="shortcut">Go to Borrowed Materials List</a>
            </div>
        </div>
        <div class="row">
            <div class="widget-container">
                <div class="widget">
                    <div class="w-text small">
                        <span>Today's Visits</span>
                    </div>
                    <ol id="patron-logins">
                        @foreach ($patron_logins as $patron_login)
                            <li><a href="/material/show/{{ $patron_login->patron->patron_id }}"
                                    class="shortcut-link">{{ $patron_login->patron->fullname }}</a></li>
                        @endforeach
                    </ol>
                </div>
                <a href="/borrowed-materials" class="shortcut">Patron Attendance</a>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            Echo.channel('patron.logged.in')
                .listen('PatronLoggedIn', (e) => {
                    console.log(e);
                    var patron = e.patron;
                    var patronName = patron.first_name + ' ' + patron.last_name;
                    var patronId = patron.patron_id;

                    // Create a new list item
                    var li = document.createElement('li');
                    li.innerHTML = `<a href="/material/show/${patronId}" class="shortcut-link">${patronName}</a>`;

                    // Append the new list item to the list
                    document.querySelector('#patron-logins').appendChild(li);
                })
        }
    </script>

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
                            'rgb(0, 173, 181)',
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 206, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(153, 102, 255)',
                            'rgb(255, 159, 64)',
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
                            text: 'Visits this week',
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
    </script>
@endsection
