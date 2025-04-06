@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    @include('include.report_tabs')
    <div class="container">
        <h5 class="mb-3">Login Statistics {{ \Carbon\Carbon::createFromDate($year, $month)->format('F Y') }}</h5>
        <a href="{{ route('reports.login_statistics.export', ['year' => $year, 'month' => $month]) }}" class="btn-simple">
            Export
        </a>
        <form method="GET">
            <div class="d-flex gap-3" style="width: 500px">
                <select name="year">
                    @for ($y = date('Y'); $y >= 2000; $y--)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : ''}}>{{ $y }}</option>
                    @endfor
                </select>
                <select name="month">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn-simple">Apply</button>
            </div>
        </form>
    
        @php
            $weekColors = ['#e3f2fd', '#e8f5e9', '#fff8e1', '#fce4ec', '#ede7f6']; // Color per week group
        @endphp
    
        <div class="table-responsive">
            <table class="table table-sm table-bordered text-center align-middle small table-hover">
                <thead>
                    {{-- First header row: Day initials --}}
                    <tr class="table-light">
                        <th class="text-start"></th>
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $date = \Carbon\Carbon::create($year, $month, $day);
                                $initial = $date->format('D')[0]; // First letter of day (S M T W T F S)
                                $isWeekend = $date->isSaturday() || $date->isSunday();
                                $weekGroup = ceil($day / 7) - 1;
                                $bgColor = $isWeekend ? '#fff3cd' : ($weekColors[$weekGroup % count($weekColors)]);
                            @endphp
                            <th class="fw-semibold" style="background-color: {{ $bgColor }}">{{ $initial }}</th>
                        @endfor
                        <th></th>
                    </tr>
    
                    {{-- Second header row: Day numbers --}}
                    <tr class="table-light">
                        <th class="text-start">Department</th>
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $date = \Carbon\Carbon::create($year, $month, $day);
                                $isWeekend = $date->isSaturday() || $date->isSunday();
                                $weekGroup = ceil($day / 7) - 1;
                                $bgColor = $isWeekend ? '#fff3cd' : ($weekColors[$weekGroup % count($weekColors)]);
                            @endphp
                            <th class="fw-semibold" style="background-color: {{ $bgColor }}">{{ $day }}</th>
                        @endfor
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reportData as $department => $row)
                        <tr>
                            <td class="text-start fw-semibold">{{ $department }}</td>
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $date = \Carbon\Carbon::create($year, $month, $day);
                                    $isWeekend = $date->isSaturday() || $date->isSunday();
                                    $weekGroup = ceil($day / 7) - 1;
                                    $bgColor = $isWeekend ? '#fff3cd' : ($weekColors[$weekGroup % count($weekColors)]);
                                @endphp
                                <td class="{{ $row[$day] ? 'fw-bold' : 'fw-normal'}}" style="background-color: {{ $bgColor }}">{{ $row[$day] ?? 0 }}</td>
                            @endfor
                            <td class="fw-bold">{{ $rowTotals[$department] ?? 0 }}</td>
                        </tr>
                    @endforeach
    
                    <tr class="fw-bold table-light">
                        <td>Total</td>
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $date = \Carbon\Carbon::create($year, $month, $day);
                                $isWeekend = $date->isSaturday() || $date->isSunday();
                                $weekGroup = ceil($day / 7) - 1;
                                $bgColor = $isWeekend ? '#fff3cd' : ($weekColors[$weekGroup % count($weekColors)]);
                            @endphp
                            <td style="background-color: {{ $bgColor }}">{{ $dailyTotals[$day] ?? 0 }}</td>
                        @endfor
                        <td>{{ $grandTotal ?? 0 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Type</th>
                <th scope="col">Department</th>
                <th scope="col">Patron</th>
                <th scope="col">Purpose</th>
                <th scope="col">Marketer</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patron_logins as $patron_login)
                <tr>
                    <td>{{ $patron_login->login_at->format('d/m/y') }}</td>
                    <td>{{ $patron_login->patron->type->type}}</td>
                    <td>{{ $patron_login->patron->department->departmentAcronym ?? '' }}</td>
                    <td><a class="shortcut-link" href="/patron/show/{{$patron_login->patron_id}}">{{ $patron_login->patron->first_name . ' ' . $patron_login->patron->last_name }}</a></td>
                    <td>{{ $patron_login->purpose->purpose ?? 'Not indicated'}}</td>
                    <td>{{ $patron_login->marketer->marketer ?? 'None' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
