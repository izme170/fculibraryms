@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    @vite('resources/js/app.js')
    @include('include.report_tabs')

    <div class="bg-white p-3 rounded" style="min-width: fit-content">
        <h3 class="mb-3">Most Borrowed Materials</h3>
        <div class="chart-container mt-4" style="position: relative; width:600px; margin: 0 auto;">
            <canvas id="mostBorrowedMaterialsChart"></canvas>
        </div>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Total Borrows</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($materials as $index => $material)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $material->title }}</td>
                        <td>{{ $borrowed_counts[$index] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="mt-4">Most Frequently Borrowed Categories</h3>
        <div class="chart-container mt-4" style="position: relative; width:800px; margin: 0 auto;">
            <canvas id="mostBorrowedCategoriesChart"></canvas>
        </div>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Total Borrows</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categoryNames as $index => $category)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $category }}</td>
                        <td>{{ $categoryCounts[$index] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="mt-4">Top Borrowing Departments</h3>
        <div class="chart-container mt-4" style="position: relative; width:800px; margin: 0 auto;">
            <canvas id="topBorrowerDepartmentsChart"></canvas>
        </div>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Department</th>
                    <th>Total Borrows</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departmentNames as $index => $department)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $department }}</td>
                        <td>{{ $departmentCounts[$index] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="mt-4">Top Borrowing Patrons</h3>
        <div class="chart-container mt-4" style="position: relative; width:800px; margin: 0 auto;">
            <canvas id="topPatronBorrowersChart"></canvas>
        </div>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patron Name</th>
                    <th>Total Borrows</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patronNames as $index => $name)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $name }}</td>
                        <td>{{ $patronBorrowCounts[$index] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="mt-4">Most Borrowed Material Types</h3>
        <div class="chart-container mt-4" style="position: relative; width:800px; margin: 0 auto;">
            <canvas id="mostBorrowedTypesChart"></canvas>
        </div>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Total Borrows</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($typeNames as $index => $type)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $type }}</td>
                        <td>{{ $typeCounts[$index] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Most Borrowed Materials Chart
            var ctx = document.getElementById('mostBorrowedMaterialsChart').getContext('2d');
            var mostBorrowedMaterialsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($materials->pluck('title')),
                    datasets: [{
                        label: 'Times Borrowed',
                        data: @json($borrowed_counts),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Most Borrowed Materials'
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Most Borrowed Categories Chart
            var categoryCtx = document.getElementById('mostBorrowedCategoriesChart').getContext('2d');
            var mostBorrowedCategoriesChart = new Chart(categoryCtx, {
                type: 'bar',
                data: {
                    labels: @json($categoryNames),
                    datasets: [{
                        label: 'Times Borrowed',
                        data: @json($categoryCounts),
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Most Borrowed Material Categories'
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Top Borrower Departments Chart
            var deptCtx = document.getElementById('topBorrowerDepartmentsChart').getContext('2d');
            var topBorrowerDepartmentsChart = new Chart(deptCtx, {
                type: 'bar',
                data: {
                    labels: @json($departmentNames),
                    datasets: [{
                        label: 'Borrowed Count',
                        data: @json($departmentCounts),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Top Borrower Departments'
                        },
                        legend: {
                            display: false,
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Top Patron Borrowers Chart
            var patronCtx = document.getElementById('topPatronBorrowersChart').getContext('2d');
            var topPatronBorrowersChart = new Chart(patronCtx, {
                type: 'bar',
                data: {
                    labels: @json($patronNames),
                    datasets: [{
                        label: 'Times Borrowed',
                        data: @json($patronBorrowCounts),
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Top Patron Borrowers'
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Most Borrowed Types Chart
            var typeCtx = document.getElementById('mostBorrowedTypesChart').getContext('2d');
            var mostBorrowedTypesChart = new Chart(typeCtx, {
                type: 'bar',
                data: {
                    labels: @json($typeNames),
                    datasets: [{
                        label: 'Times Borrowed',
                        data: @json($typeCounts),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Most Borrowed Material Types'
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
