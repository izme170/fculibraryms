@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <div class="option-container d-flex align-items-start">
        <div class="tab-links nav flex-column align-items-start nav-pills" id="v-pills-tab" role="tablist"
            aria-orientation="vertical">
            <button class="tab-link active" id="advisers-tab" data-bs-toggle="pill" data-bs-target="#advisers" type="button"
                role="tab" aria-controls="advisers" aria-selected="true">Advisers</button>
            <button class="tab-link" id="categories-tab" data-bs-toggle="pill" data-bs-target="#categories" type="button"
                role="tab" aria-controls="categories" aria-selected="false">Categories</button>
            <button class="tab-link" id="courses-tab" data-bs-toggle="pill" data-bs-target="#courses" type="button"
                role="tab" aria-controls="courses" aria-selected="false">Courses</button>
            <button class="tab-link" id="departments-tab" data-bs-toggle="pill" data-bs-target="#departments" type="button"
                role="tab" aria-controls="departments" aria-selected="false">Departments</button>
        </div>


        <div class="tab-content" id="v-pills-tabContent">

            <div class="tab-pane fade show active" id="advisers" role="tabpanel" aria-labelledby="advisers-tab"
                tabindex="0">
                <h1>Advisers</h1>
                <div class="list-container mb-3">
                    <table>
                        <tbody>
                            @foreach ($advisers as $adviser)
                                <tr>
                                    <td>{{ $adviser->adviser }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <form action="/adviser/store" method="post">
                    @csrf
                    <input type="text" name="adviser" placeholder="Enter new adviser's full name here..." required>
                    <button type="submit" class="btn-simple">Add</button>
                </form>
            </div>

            <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-tab" tabindex="0">
                <h1>Book Categories</h1>
                <div class="list-container mb-3">
                    <table>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->category }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <form action="/category/store" method="post">
                    @csrf
                    <input type="text" name="category" placeholder="Enter new book category here..." required>
                    <button type="submit" class="btn-simple">Add</button>
                </form>
            </div>

            <div class="tab-pane fade" id="courses" role="tabpanel" aria-labelledby="courses-tab" tabindex="0">
                <h1>Courses</h1>
                <div class="list-container mb-3">
                    <table>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr>
                                    <td>{{ $course->course }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <form action="/course/store" method="post">
                    @csrf
                    <input class="mb-3" type="text" name="course" placeholder="Type new course here..." required>
                    <select name="department_id" id="department_id" required>
                        <option value="">Select course's department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->department_id }}">{{ $department->department }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-simple">Add</button>
                </form>
            </div>

            <div class="tab-pane fade" id="departments" role="tabpanel" aria-labelledby="departments-tab" tabindex="0">
                <h1>Departments</h1>
                <div class="list-container mb-3">
                    <table>
                        <tbody>
                            @foreach ($departments as $department)
                                <tr>
                                    <td>{{ $department->department }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <form action="/department/store" method="post">
                    @csrf
                    <input class="mb-3" type="text" name="department" placeholder="Type new department here..." required>
                    <button type="submit" class="btn-simple">Add</button>
                </form>
            </div>
        </div>
    </div>
@endsection
