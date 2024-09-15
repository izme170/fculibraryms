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
                <button class="btn-simple">Add</button>
                <div class="list-container">
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
            </div>

            <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-tab" tabindex="0">
                <h1>Book Categories</h1>
                <button class="btn-simple">Add</button>
                <div class="list-container">
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
            </div>

            <div class="tab-pane fade" id="courses" role="tabpanel" aria-labelledby="courses-tab" tabindex="0">
                <h1>Courses</h1>
                <button class="btn-simple">Add</button>
                <div class="list-container">
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
            </div>

            <div class="tab-pane fade" id="departments" role="tabpanel" aria-labelledby="departments-tab" tabindex="0">
                <h1>Departments</h1>
                <button class="btn-simple">Add</button>
                <div class="list-container">
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
            </div>
        </div>
    </div>
@endsection
