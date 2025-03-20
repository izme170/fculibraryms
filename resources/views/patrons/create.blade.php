@extends('layout.main')
@include('include.sidenav')
@section('user-content')
@include('include.topbar')
    <div class="widget">
        <a href="{{ route('patrons.index') }}" class="text-decoration-none text-dark">
            <x-lucide-arrow-left width="30" class="mb-2" />
        </a>
        <div class="form-container">
            <form action="/patron/store" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="image">Patron Image</label>
                            <input type="file" id="image" name="patron_image" accept="image/*" onchange="previewImage(event)"
                                style="display: none;">
                            <img id="imagePreview" src="{{ asset('img/default-user-image.png') }}" alt="Image Preview"
                                style="max-width: 200px; display: block; margin-top: 10px; cursor: pointer;"
                                onclick="document.getElementById('image').click();">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="type_id">Patron Type</label>
                            <select id="type_id" name="type_id">
                                @foreach ($patron_types as $patron_type)
                                    <option value="{{ $patron_type->type_id }}">{{ $patron_type->type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="first_name">Firstname</label>
                            <input type="text" id="first_name" name="first_name" autofocus
                                value="{{ old('first_name') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="middle_name">Middle Name</label>
                            <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="last_name">Lastname</label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="text" id="email" name="email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="contact_number">Contact Number</label>
                            <input type="text" id="contact_number" name="contact_number"
                                value="{{ old('contact_number') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="school_id">School ID</label>
                            <input type="text" id="school_id" name="school_id" value="{{ old('school_id') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="department_id">Department</label>
                            <select id="department_id" name="department_id" onchange="fetchCourses()">
                                <option value="">Select Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->department_id }}"
                                        {{ old('department_id') == $department->department_id ? 'selected' : '' }}>
                                        {{ $department->department }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="course_id">Course</label>
                            <select id="course_id" name="course_id">
                                <option value="">Select Course</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="year">Year</label>
                            <input type="text" id="year" name="year">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="adviser_id">Adviser</label>
                            <select id="adviser_id" name="adviser_id">
                                <option value="">Select Adviser</option>
                                @foreach ($advisers as $adviser)
                                    <option value="{{ $adviser->adviser_id }}">{{ $adviser->adviser }}</option>
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
    </div>

    <script>
        function fetchCourses() {
            var departmentId = document.getElementById('department_id').value;
            var courseSelect = document.getElementById('course_id');
            courseSelect.innerHTML = '<option value="">Select Course</option>'; // Clear previous options

            if (departmentId) {
                fetch(`/api/courses/${departmentId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(course => {
                            var option = document.createElement('option');
                            option.value = course.course_id;
                            option.text = course.course;
                            courseSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching courses:', error));
            }
        }

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('imagePreview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
