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
}
