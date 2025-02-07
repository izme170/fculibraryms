@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    <div class="widget">
        <div class="option-container d-flex align-items-start">
            <div class="tab-links nav flex-column align-items-start nav-pills" id="v-pills-tab" role="tablist"
                aria-orientation="vertical">
                <button class="tab-link active" id="advisers-tab" data-bs-toggle="pill" data-bs-target="#advisers"
                    type="button" role="tab" aria-controls="advisers" aria-selected="true">Advisers</button>
                <button class="tab-link" id="categories-tab" data-bs-toggle="pill" data-bs-target="#categories"
                    type="button" role="tab" aria-controls="categories" aria-selected="false">Categories</button>
                <button class="tab-link" id="courses-tab" data-bs-toggle="pill" data-bs-target="#courses" type="button"
                    role="tab" aria-controls="courses" aria-selected="false">Courses</button>
                <button class="tab-link" id="departments-tab" data-bs-toggle="pill" data-bs-target="#departments"
                    type="button" role="tab" aria-controls="departments" aria-selected="false">Departments</button>
                <button class="tab-link" id="marketers-tab" data-bs-toggle="pill" data-bs-target="#marketers" type="button"
                    role="tab" aria-controls="marketers" aria-selected="false">Marketers</button>
                <button class="tab-link" id="purposes-tab" data-bs-toggle="pill" data-bs-target="#purposes" type="button"
                    role="tab" aria-controls="purposes" aria-selected="false">Purposes</button>
                <button class="tab-link" id="remarks-tab" data-bs-toggle="pill" data-bs-target="#remarks" type="button"
                    role="tab" aria-controls="remarks" aria-selected="false">Remarks</button>
            </div>


            <div class="tab-content" id="v-pills-tabContent">

                <div class="tab-pane fade show active" id="advisers" role="tabpanel" aria-labelledby="advisers-tab"
                    tabindex="0">
                    <h1>Advisers</h1>
                    <div class="list-container mb-3 p-1">
                        <table>
                            <tbody>
                                @foreach ($advisers as $adviser)
                                    <tr>
                                        <td>{{ $adviser->adviser }} @livewire('adviser-toggle', ['adviser' => $adviser])</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <form action="/adviser/store" method="post">
                        @csrf
                        <div class="d-flex">
                            <input type="text" name="adviser" placeholder="Enter new adviser's full name here..."
                                required>
                            <button type="submit" class="btn-rectangle">Add</button>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-tab" tabindex="0">
                    <h1>Book Categories</h1>
                    <div class="list-container mb-3">
                        <table>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->category }} @livewire('category-toggle', ['category' => $category])</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <form action="/category/store" method="post">
                        @csrf
                        <div class="d-flex">
                            <input type="text" name="category" placeholder="Enter new book category here..." required>
                            <button type="submit" class="btn-rectangle">Add</button>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="courses" role="tabpanel" aria-labelledby="courses-tab" tabindex="0">
                    <h1>Courses</h1>
                    <div class="list-container mb-3">
                        <table>
                            <tbody>
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $course->course }} @livewire('course-toggle', ['course' => $course])</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <form action="/course/store" method="post">
                        @csrf
                        <input class="mb-3" type="text" name="course" placeholder="Type new course here..."
                            required>
                        <div class="mb-3">
                            <select name="department_id" id="department_id" required>
                                <option value="">Select course's department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->department_id }}">{{ $department->department }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn-rectangle">Add</button>
                    </form>
                </div>

                <div class="tab-pane fade" id="departments" role="tabpanel" aria-labelledby="departments-tab"
                    tabindex="0">
                    <h1>Departments</h1>
                    <div class="list-container mb-3">
                        <table>
                            <tbody>
                                @foreach ($departments as $department)
                                    <tr>
                                        <td>{{ $department->department }} @livewire('department-toggle', ['department' => $department])</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <form action="/department/store" method="post">
                        @csrf
                        <div class="d-flex">
                            <input type="text" name="department" placeholder="Type new department here..." required>
                            <button type="submit" class="btn-rectangle">Add</button>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="marketers" role="tabpanel" aria-labelledby="marketers-tab"
                    tabindex="0">
                    <h1>Marketers</h1>
                    <div class="list-container mb-3">
                        <table>
                            <tbody>
                                @foreach ($marketers as $marketer)
                                    <tr>
                                        <td>{{ $marketer->marketer }} @livewire('marketer-toggle', ['marketer' => $marketer])</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <form action="/marketer/store" method="post">
                        @csrf
                        <div class="d-flex">
                            <input type="text" name="marketer" placeholder="Type new marketer here..." required>
                            <button type="submit" class="btn-rectangle">Add</button>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="purposes" role="tabpanel" aria-labelledby="purposes-tab"
                    tabindex="0">
                    <h1>Purposes</h1>
                    <div class="list-container mb-3">
                        <table>
                            <tbody>
                                @foreach ($purposes as $purpose)
                                    <tr>
                                        <td>{{ $purpose->purpose }} @livewire('purpose-toggle', ['purpose' => $purpose])</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <form action="/purpose/store" method="post">
                        @csrf
                        <div class="d-flex">
                            <input type="text" name="purpose" placeholder="Type new purpose here..." required>
                            <button type="submit" class="btn-rectangle">Add</button>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="remarks" role="tabpanel" aria-labelledby="remarks-tab" tabindex="0">
                    <h1>Remarks</h1>
                    <div class="list-container mb-3">
                        <table>
                            <tbody>
                                @foreach ($remarks as $remark)
                                    <tr>
                                        <td>{{ $remark->remark }} @livewire('remark-toggle', ['remark' => $remark])</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <form action="/remark/store" method="post">
                        @csrf
                        <div class="d-flex">
                            <input type="text" name="remark" placeholder="Type new remark here..." required>
                            <button type="submit" class="btn-rectangle">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
