@extends('layout.main')
@include('include.sidenav_admin')
@section('user-content')
@include('include.messages')
<div class="form-container">
    <form action="/admin/patron/store" method="post">
        @csrf
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label class="form-label" for="type_id">Patron Type</label>
                    <select id="type_id" name="type_id">
                        <option value="">Select Patron Type</option>
                        @foreach ($patron_types as $patron_type)
                            <option value="{{$patron_type->type_id}}">{{$patron_type->type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="first_name">Firstname</label>
                    <input type="text" id="first_name" name="first_name">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="middle_name">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="last_name">Lastname</label>
                    <input type="text" id="last_name" name="last_name">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="text" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="contact_number">Contact Number</label>
                    <input type="text" id="contact_number" name="contact_number">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="address">Address</label>
                    <input type="text" id="address" name="address">
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label class="form-label" for="school_id">School ID</label>
                    <input type="text" id="school_id" name="school_id">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="department_id">Department</label>
                    <select id="department_id" name="department_id">
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{$department->department_id}}">{{$department->department}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="course_id">Course</label>
                    <select id="course_id" name="course_id">
                        <option value="">Select Course</option>
                        @foreach ($courses as $course)
                            <option value="{{$course->course_id}}">{{$course->course}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="year">Year</label>
                    <input type="text" id="year" name="year">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="adviser_id">Adviser</label>
                    <select id="adviser_id" name="adviser_id">
                        <option value="">Select Adviser</option>
                        @foreach ($advisers as $adviser)
                            <option value="{{$adviser->adviser_id}}">{{$adviser->adviser}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="library_id">RFID</label>
                    <input type="text" id="library_id" name="library_id">
                </div>
            </div>
        </div>
        <button class="btn-simple btn-right" type="submit">Submit</button>
    </form>
</div>
@endsection