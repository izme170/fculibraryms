<?php

namespace App\Imports;

use App\Models\Adviser;
use App\Models\Course;
use App\Models\Department;
use App\Models\Patron;
use App\Models\PatronType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PatronImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $type = PatronType::firstOrCreate(['type' => $row['type']]);
        $department = Department::firstOrCreate(['department' => $row['department']]);
        $course = Course::firstOrCreate(['course' => $row['course']],['department_id' => $department->department_id]);
        $adviser = Adviser::firstOrCreate(['adviser' => $row['adviser']]);
        return new Patron([
            'first_name' => $row['first_name'],
            'middle_name' => $row['middle_name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            'contact_number' => $row['contact_number'],
            'type_id' => $type->type_id,
            'address' => $row['address'],
            'school_id' => $row['school_id'],
            'department_id' => $department->department_id,
            'course_id' => $course->course_id,
            'year' => $row['year'],
            'adviser_id' => $adviser->adviser_id
        ]);
    }
}
