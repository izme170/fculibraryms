<?php

namespace App\Http\Controllers;

use App\Models\BorrowedMaterial;
use App\Models\Department;
use App\Models\Patron;
use App\Models\PatronLogin;
use App\Models\PatronType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $request->merge([
            'year' => $request->input('year', now()->year),
            'month' => $request->input('month', null),
        ]);

        $validated = $request->validate([
            'year' => 'required|integer|between:2000,' . now()->year,
            'month' => 'nullable|integer|between:1,12',
        ]);

        $year = $validated['year'];
        $month = $validated['month'] ?? null;

        // Base query for both top patrons, marketers, and departments
        $query = PatronLogin::whereYear('login_at', $year);
        if ($month) {
            $query->whereMonth('login_at', $month);
        }

        // Clone the query for each dataset
        $patronQuery = clone $query;
        $marketerQuery = clone $query;
        $departmentQuery = clone $query;

        // Get top patrons
        $topPatrons = $patronQuery->join('patrons', 'patron_logins.patron_id', '=', 'patrons.patron_id')
            ->selectRaw('CONCAT(first_name, " ", last_name) AS full_name, COUNT(login_id) as logins')
            ->groupBy('patron_logins.patron_id', 'full_name')
            ->orderByDesc('logins')
            ->limit(10)
            ->get();

        // Get top marketers
        $topMarketers = $marketerQuery->join('marketers', 'patron_logins.marketer_id', '=', 'marketers.marketer_id')
            ->selectRaw('marketers.marketer, COUNT(login_id) as marketerCounts')
            ->groupBy('marketers.marketer_id', 'marketers.marketer')
            ->orderByDesc('marketerCounts')
            ->limit(10)
            ->get();

        // Get top departments
        $topDepartments = $departmentQuery->join('patrons', 'patron_logins.patron_id', '=', 'patrons.patron_id')
            ->join('departments', 'patrons.department_id', '=', 'departments.department_id')
            ->selectRaw('departments.department AS department_name, COUNT(login_id) as logins')
            ->groupBy('departments.department_id', 'departments.department')
            ->orderByDesc('logins')
            ->get();

        // Prepare chart data
        $patronNames = $topPatrons->pluck('full_name')->toArray();
        $loginCounts = $topPatrons->pluck('logins')->toArray();

        $marketerNames = $topMarketers->pluck('marketer')->toArray();
        $marketerCounts = $topMarketers->pluck('marketerCounts')->toArray();

        $departmentNames = $topDepartments->pluck('department_name')->toArray();
        $departmentCounts = $topDepartments->pluck('logins')->toArray();

        return view('reports.index', compact(
            'patronNames',
            'loginCounts',
            'marketerNames',
            'marketerCounts',
            'departmentNames',
            'departmentCounts',
            'year',
            'month'
        ));
    }

    public function loginStatistics(Request $request)
    {
        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);

        $daysInMonth = now()->setYear($year)->setMonth($month)->daysInMonth;

        $departments = \App\Models\Department::all(); // get whole department model for acronym use
        $reportData = [];
        $rowTotals = [];
        $dailyTotals = array_fill(1, $daysInMonth, 0);

        foreach ($departments as $department) {
            $row = [];
            $rowTotal = 0;

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $count = \App\Models\PatronLogin::whereDay('login_at', $day)
                    ->whereMonth('login_at', $month)
                    ->whereYear('login_at', $year)
                    ->whereHas('patron', function ($q) use ($department) {
                        $q->where('type_id', 1) //student only
                            ->where('department_id', $department->department_id);
                    })->count();

                $row[$day] = $count;
                $dailyTotals[$day] += $count;
                $rowTotal += $count;
            }

            // Generate acronym for department name
            $words = explode(' ', $department->department);
            $acronym = implode('', array_map(function ($word) {
                return in_array(strtolower($word), ['of', 'and', 'the', 'a', 'an', 'in']) ? '' : strtoupper($word[0]);
            }, $words));

            $reportData[$acronym] = $row;
            $rowTotals[$acronym] = $rowTotal;
        }

        // Faculty Row
        $facultyRow = [];
        $facultyTotal = 0;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $count = \App\Models\PatronLogin::whereDay('login_at', $day)
                ->whereMonth('login_at', $month)
                ->whereYear('login_at', $year)
                ->whereHas('patron', function ($q) {
                    $q->where('type_id', 2); //faculty only
                })->count();
            $facultyRow[$day] = $count;
            $dailyTotals[$day] += $count;
            $facultyTotal += $count;
        }
        $reportData['FACULTY'] = $facultyRow;
        $rowTotals['FACULTY'] = $facultyTotal;

        // Guest Row
        $guestRow = [];
        $guestTotal = 0;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $count = \App\Models\PatronLogin::whereDay('login_at', $day)
                ->whereMonth('login_at', $month)
                ->whereYear('login_at', $year)
                ->whereHas('patron', function ($q) {
                    $q->where('type_id', 3); //guest only
                })->count();
            $guestRow[$day] = $count;
            $dailyTotals[$day] += $count;
            $guestTotal += $count;
        }
        $reportData['GUEST'] = $guestRow;
        $rowTotals['GUEST'] = $guestTotal;

        $grandTotal = array_sum($rowTotals);

        $patron_logins = PatronLogin::orderBy('login_at')->whereMonth('login_at', $month)->get();

        return view('reports.login_statistics', compact(
            'reportData',
            'rowTotals',
            'dailyTotals',
            'grandTotal',
            'daysInMonth',
            'year',
            'month',
            'patron_logins'
        ));
    }

    public function monthlyLoginStatistics(Request $request)
    {
        $year = (int) $request->input('year', now()->year);

        $departments = Department::all();
        $reportData = [];
        $monthlyTotals = array_fill(1, 12, 0);
        $rowTotals = [];

        // Student counts per department
        foreach ($departments as $department) {
            $row = [];
            $rowTotal = 0;

            for ($month = 1; $month <= 12; $month++) {
                $count = PatronLogin::whereYear('login_at', $year)
                    ->whereMonth('login_at', $month)
                    ->whereHas('patron', function ($q) use ($department) {
                        $q->where('type_id', 1)
                            ->where('department_id', $department->department_id);
                    })->count();

                $row[$month] = $count;
                $monthlyTotals[$month] += $count;
                $rowTotal += $count;
            }

            $reportData[$department->department] = $row;
            $rowTotals[$department->department] = $rowTotal;
        }

        // Add Faculty row
        $facultyRow = [];
        $facultyTotal = 0;
        for ($month = 1; $month <= 12; $month++) {
            $count = PatronLogin::whereYear('login_at', $year)
                ->whereMonth('login_at', $month)
                ->whereHas('patron', function ($q) {
                    $q->where('type_id', 2);
                })->count();

            $facultyRow[$month] = $count;
            $monthlyTotals[$month] += $count;
            $facultyTotal += $count;
        }
        $reportData['FACULTY'] = $facultyRow;
        $rowTotals['FACULTY'] = $facultyTotal;

        // Add Guest row
        $guestRow = [];
        $guestTotal = 0;
        for ($month = 1; $month <= 12; $month++) {
            $count = PatronLogin::whereYear('login_at', $year)
                ->whereMonth('login_at', $month)
                ->whereHas('patron', function ($q) {
                    $q->where('type_id', 3);
                })->count();

            $guestRow[$month] = $count;
            $monthlyTotals[$month] += $count;
            $guestTotal += $count;
        }
        $reportData['GUEST'] = $guestRow;
        $rowTotals['GUEST'] = $guestTotal;

        $grandTotal = array_sum($rowTotals);

        return view('reports.monthly_login_statistics', compact(
            'reportData',
            'rowTotals',
            'monthlyTotals',
            'grandTotal',
            'year'
        ));
    }

    public function unreturnedMaterials(){
        $unreturned_materials = BorrowedMaterial::orderBy('created_at')->whereNull('returned')->get();

        return view('reports.unreturned_materials', compact('unreturned_materials'));
    }
}
