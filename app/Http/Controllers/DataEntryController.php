<?php

namespace App\Http\Controllers;

use App\Models\Adviser;
use App\Models\Category;
use App\Models\Course;
use App\Models\Department;
use App\Models\Marketer;
use App\Models\Purpose;
use Illuminate\Http\Request;

class DataEntryController extends Controller
{
    public function index()
    {
        $advisers = Adviser::orderBy('adviser')->get();
        $categories = Category::orderBy('category')->get();
        $courses = Course::orderBy('course')->get();
        $departments = Department::orderBy('department')->get();
        $marketers = Marketer::orderBy('marketer')->get();
        $purposes = Purpose::orderBy('purpose')->get();

        return view('data_entries.index', compact([
            'advisers',
            'categories',
            'courses',
            'departments',
            'marketers',
            'purposes'
        ]));
    }

    public function storeAdviser(Request $request)
    {
        $validated = $request->validate([
            'adviser' => 'required'
        ]);

        Adviser::create($validated);
        return redirect()->back();
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required'
        ]);

        Category::create($validated);
        return redirect()->back();
    }

    public function storeCourse(Request $request)
    {
        $validated = $request->validate([
            'course' => 'required',
            'department_id' => 'required|exists:departments,department_id'
        ]);

        Course::create($validated);
        return redirect()->back();
    }

    public function storeDepartment(Request $request)
    {
        $validated = $request->validate([
            'department' => 'required'
        ]);

        Department::create($validated);
        return redirect()->back();
    }

    public function storeMarketer(Request $request)
    {
        $validated = $request->validate([
            'marketer' => 'required'
        ]);

        Marketer::create($validated);
        return redirect()->back();
    }

    public function storePurpose(Request $request)
    {
        $validated = $request->validate([
            'purpose' => 'required'
        ]);

        Purpose::create($validated);
        return redirect()->back();
    }
}
