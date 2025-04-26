@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    @vite('resources/js/app.js')
    <div class="col p-3">

        {{-- Buttons --}}
        <div class="row mb-3">
            <div>
                <a class="btn-simple d-inline-flex align-items-center gap-1" href="/borrow-material"><x-fas-plus
                        width="12" /> Borrow Material</a>
                <a class="btn-simple d-inline-flex align-items-center gap-1" href="/return-material"><x-fas-arrow-right
                        width="12" /> Return Material</a>
            </div>
        </div>

        {{-- Counts --}}
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
                @if (auth()->user()->role->materials_access)
                    <a href="{{ route('material-copies.index') }}"
                        class="card w-25 shadow-sm rounded-3 bg-warning-subtle border-0 text-decoration-none">
                        <div class="card-body d-flex align-items-center">
                            <x-fas-copy class="text-warning me-3" width="50" />
                            <div>
                                <div class="fs-5 fw-bold text-warning">Copies</div>
                                <div class="fs-5 text-warning"> {{ $copy_count }} </div>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
        </div>

        {{-- Widgets --}}
        <div class="d-flex flex-wrap gap-3 mb-3">

            {{-- Chart --}}
            <div class="card border-0" style="width: fit-content;">
                <div class="card-body">
                    <div class="w-text small d-flex align-items-center gap-2">
                        <x-fas-user width="20" />
                        Visits today: {{ $visits_today }}
                    </div>
                    <div class="chart-container mb-3" style="position: relative; width:500px">
                        <canvas id="dailyVisitChart"></canvas>
                    </div>
                    <a href="/patron-logins"
                        class="btn-simple d-inline-flex align-items-center gap-1"><x-fas-arrow-up-right-from-square
                            width="12" />Access Log</a>
                </div>
            </div>

            {{-- Unreturned materials --}}
            <div class="card border-0 w-50">
                <div class="card-header">
                        <p class="fw-bold fs-5 text-center">{{ $unreturnedMaterials->count() }} Borrowed Materials</p>
                </div>
                <div class="card-body overflow-auto">
                    <div class="col">
                        @foreach ($unreturnedMaterials as $borrowedMaterial)
                            <div class="row p-1 border-bottom">
                                <a href="/copy/show/{{ $borrowedMaterial->materialCopy->copy_id }}" class="col fw-semibold shortcut-link">{{ $borrowedMaterial->materialCopy->material->title }}</a>
                                <div class="col d-flex flex-row align-items-center gap-2">
                                    <img src="{{ $borrowedMaterial->patron->patron_image ? asset('storage/' . $borrowedMaterial->patron->patron_image) : asset('img/default-patron-image.png') }}"
                                        alt="Patron Image" style="width: 30px;object-fit: cover; border-radius: 100%;">
                                    <div class="d-flex flex-column">
                                        <a href="/patron/show/{{ $borrowedMaterial->patron->patron_id }}" class="shortcut-link">{{ $borrowedMaterial->patron->fullname }}</a>
                                        <div>{{ $borrowedMaterial->created_at->format('m/d/y') }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('borrowed-materials.index') }}"
                        class="btn-simple d-inline-flex align-items-center gap-1 mt-3"><x-fas-arrow-up-right-from-square
                            width="12" />Borrowed Materials</a>
                </div>
            </div>

            {{-- List of today's visits --}}
            <div class="card border-0 w-50">
                <div class="card-header">
                    <p class="fw-bold fs-5 text-center">Today's login</p>
                </div>
                <div class="card-body overflow-auto" id="patron-logins" style="height:300px">
                    @foreach ($patron_logins as $patron_login)
                        <a href="/patron/show/{{ $patron_login->patron->patron_id }}" class="row align-items-center p-1 border-bottom shortcut-link">
                            <div class="col d-flex align-items-center justify-content-start gap-1">
                                <img src="{{ $patron_login->patron->patron_image ? asset('storage/' . $patron_login->patron->patron_image) : asset('img/default-patron-image.png') }}"
                                    alt="Patron Image" style="width: 50px; object-fit: cover; border-radius: 100%;">
                                <div class="fw-semibold">{{ $patron_login->patron->fullname }}</div>
                            </div>
                            <div class="col">{{ $patron_login->login_at->format('g:i a') }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            Echo.channel('patron.logged.in')
                .listen('PatronLoggedIn', (e) => {
                    console.log(e);
                    var patron = e.patron;
                    var patronName = patron.name; // already full name
                    var patronId = patron.id;
                    var patronImage = patron.image;
                    var patronLoginAt = patron.login_at;

                    // Create a new entry item
                    var entry = document.createElement('a');
                    entry.className = 'row p-1 border-bottom align-items-center shortcut-link'
                    entry.href = "/patron/show/" + patronId;
                    entry.innerHTML = `
                    <div class="col d-flex align-items-center justify-content-start gap-1">
                        <img src="${patronImage}" alt="Patron Image"
                            style="width: 50px; object-fit: cover; border-radius: 100%;">
                        <div class="fw-semibold">${patronName}</div>
                    </div>
                    <div class="col">${patronLoginAt}</div>
            `;

                    // Append the new entry to the list
                    document.querySelector('#patron-logins').prepend(entry);
                });
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
                        borderRadius: 5,
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
