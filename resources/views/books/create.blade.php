@extends('layout.main')
@include('include.sidenav_admin')
@section('user-content')
@include('include.messages')
<div class="form-container">
    <form action="/admin/book/store" method="post">
        @csrf
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="author">Author</label>
                    <input type="text" id="author" name="author">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="category_id">category</label>
                    <select id="category_id" name="category_id">
                        <option value="">Select Patron Type</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->category_id}}" {{$category->category_id == '1' ? 'selected' : ''}}>
                                {{$category->category}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="qty">Qty</label>
                    <input type="numeric" id="qty" name="qty">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="book_number">Book Number</label>
                    <input type="numeric" id="book_number" name="book_number">
                </div>
            </div>
        </div>
        <button class="btn-simple btn-right" type="submit">Submit</button>
    </form>
</div>
@endsection