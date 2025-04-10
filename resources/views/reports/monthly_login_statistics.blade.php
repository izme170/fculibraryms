@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    @include('include.report_tabs')

    <div class="container">
        <h5 class="mb-3">Monthly Login Statistics – {{ $year }}</h5>
        <form method="GET">
            <div class="d-flex gap-3" style="width: 300px">
                <select name="year">
                    @for ($y = date('Y'); $y >= 2000; $y--)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn-simple">Apply</button>
            </div>
        </form>
        <a href="{{ route('reports.monthly_login_statistics.export', ['year' => $year]) }}" class="btn-simple mb-3">
            Export
        </a>

        @php
            $monthColors = ['#e3f2fd', '#e8f5e9', '#fff8e1', '#fce4ec', '#ede7f6']; // Color per month group
        @endphp

        <div class="table-responsive mt-4">
            <table class="table table-sm table-bordered text-center align-middle small table-hover">
                <thead>
                    {{-- First header row: Month initials --}}
                    <tr class="table-light">
                        <th class="text-start">Department</th>
                        @for ($month = 1; $month <= 12; $month++)
                            @php
                                $monthName = date('M', mktime(0, 0, 0, $month, 10)); // Short month name
                                $bgColor = $monthColors[($month - 1) % count($monthColors)];
                            @endphp
                            <th class="fw-semibold" style="background-color: {{ $bgColor }}">{{ $monthName }}</th>
                        @endfor
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reportData as $department => $row)
                        <tr>
                            <td class="text-start fw-semibold">{{ $department }}</td>
                            @for ($month = 1; $month <= 12; $month++)
                                @php
                                    $bgColor = $monthColors[($month - 1) % count($monthColors)];
                                @endphp
                                <td class="{{ $row[$month] ? 'fw-bold' : 'fw-normal' }}" style="background-color: {{ $bgColor }}">{{ $row[$month] ?? 0 }}</td>
                            @endfor
                            <td class="fw-bold">{{ $rowTotals[$department] ?? 0 }}</td>
                        </tr>
                    @endforeach
                    <tr class="fw-bold table-light">
                        <td>Total</td>
                        @for ($month = 1; $month <= 12; $month++)
                            @php
                                $bgColor = $monthColors[($month - 1) % count($monthColors)];
                            @endphp
                            <td style="background-color: {{ $bgColor }}">{{ $monthlyTotals[$month] ?? 0 }}</td>
                        @endfor
                        <td>{{ $grandTotal ?? 0 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection