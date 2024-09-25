<?php

namespace App\Http\Controllers;

use App\Models\Adviser;
use App\Models\Category;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index(){
        $advisers = Adviser::orderBy('adviser')->get();
        $categories = Category::orderBy('category')->get();
        $courses = Course::orderBy('course')->get();
        $departments = Department::orderBy('department')->get();

        return view('options.index', compact([
            'advisers',
            'categories',
            'courses',
            'departments'
        ]));
    }

    public function storeAdviser(Request $request){
        $validated = $request->validate([
            'adviser' => 'required'
        ]);

        Adviser::create($validated);
        return redirect()->back();
    }

    public function storeCategory(Request $request){
        $validated = $request->validate([
            'category' => 'required'
        ]);

        Category::create($validated);
        return redirect()->back();
    }

    public function storeCourse(Request $request){
        $validated = $request->validate([
            'course' => 'required',
            'department_id' => 'required|exists:departments,department_id'
        ]);

        Course::create($validated);
        return redirect()->back();
    }

    public function storeDepartment(Request $request){
        $validated = $request->validate([
            'department' => 'required'
        ]);

        Department::create($validated);
        return redirect()->back();
    }
}
