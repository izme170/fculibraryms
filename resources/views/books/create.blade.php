@extends('layout.main')
@include('include.sidenav')
@section('user-content')
@include('include.topbar')
    <div class="widget">
        <div class="form-container">
            <form action="/book/store" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="book_image">Book Image</label>
                            <input type="file" id="book_image" name="book_image" accept="image/*"
                                onchange="previewImage(event)" style="display: none;">
                            <img id="imagePreview" src="{{ asset('img/default-book-image.png') }}" alt="Image Preview"
                                style="max-width: 200px; display: block; margin-top: 10px; cursor: pointer;"
                                onclick="document.getElementById('book_image').click();">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="title">Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="author">Author</label>
                            <input type="text" id="author" name="author" value="{{ old('author') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="category_id">Category</label>
                            <select id="category_id" name="category_id">
                                <option value="">Select book category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}"
                                        {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                        {{ $category->category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="book_number">Scan book's RFID here to submit</label>
                            <input type="text" id="book_number" name="book_number">
                        </div>
                    </div>
                </div>
                <button class="btn-simple btn-right" type="submit" hidden>Submit</button>
            </form>
        </div>
    </div>

    <script>
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
