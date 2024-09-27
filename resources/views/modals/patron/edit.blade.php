<div class="modal fade" id="editPatron" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Patron</h1>
            </div>
            <div class="modal-body">
                <form action="/patron/update/{{ $patron->patron_id }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="type_id">Patron Type</label>
                                <select id="type_id" name="type_id">
                                    @foreach ($patron_types as $patron_type)
                                        <option value="{{ $patron_type->type_id }}"
                                            {{ $patron->type_id == $patron_type->type_id ? 'selected' : '' }}>
                                            {{ $patron_type->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="first_name">Firstname</label>
                                <input type="text" id="first_name" name="first_name"
                                    value="{{ $patron->first_name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="middle_name">Middle Name</label>
                                <input type="text" id="middle_name" name="middle_name"
                                    value="{{ $patron->middle_name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="last_name">Lastname</label>
                                <input type="text" id="last_name" name="last_name" value="{{ $patron->last_name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" id="email" name="email" value="{{ $patron->email }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="contact_number">Contact Number</label>
                                <input type="text" id="contact_number" name="contact_number"
                                    value="{{ $patron->contact_number }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="address">Address</label>
                                <input type="text" id="address" name="address" value="{{ $patron->address }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="school_id">School ID</label>
                                <input type="text" id="school_id" name="school_id" value="{{ $patron->school_id }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="department_id">Department</label>
                                <select id="department_id" name="department_id">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->department_id }}">{{ $department->department }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="course_id">Course</label>
                                <select id="course_id" name="course_id">
                                    <option value="">Select Course</option>
                                    @if (isset($courses))
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->course_id }}">{{ $course->course }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="year">Year</label>
                                <input type="text" id="year" name="year" value="{{ $patron->year }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="adviser_id">Adviser</label>
                                <select id="adviser_id" name="adviser_id">
                                    @foreach ($advisers as $adviser)
                                        <option value="{{ $adviser->adviser_id }}"
                                            {{ $patron->adviser_id == $adviser->adviser_id ? 'selected' : '' }}>
                                            {{ $adviser->adviser }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-row justify-content-end gap-1">
                            <button class="btn-simple bg-red" type="button" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                            <button class="btn-simple" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const departmentSelect = document.getElementById('department_id');
        const courseSelect = document.getElementById('course_id');

        departmentSelect.addEventListener('change', function() {
            const departmentId = this.value;

            // Clear the course dropdown
            courseSelect.innerHTML = '<option value="">Select Course</option>';

            if (departmentId) {
                fetch(`/courses/${departmentId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.length > 0) {
                            data.forEach(course => {
                                const option = document.createElement('option');
                                option.value = course.course_id;
                                option.textContent = course.course;
                                courseSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching courses:', error);
                    });
            }
        });
    });
</script>
