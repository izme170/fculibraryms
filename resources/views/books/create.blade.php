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
                        <div>
                            <label class="form-label" for="author">Author</label>
                            <div id="author-container">
                                <input class="mb-1" type="text" id="author" name="author[]" value="{{ old('author') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn-rectangle" type="button" onclick="addAuthorInput()">Add Another Author</button>
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
                            <label class="form-label" for="book_rfid">Scan book's RFID here to submit</label>
                            <input type="text" id="book_rfid" name="book_rfid">
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

        function addAuthorInput() {
            var container = document.getElementById('author-container');
            var div = document.createElement('div');
            div.className = 'author-input-group mt-2';
            var input = document.createElement('input');
            input.type = 'text';
            input.name = 'author[]';
            var button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn-rectangle btn-sm my-1';
            button.innerText = 'Remove';
            button.onclick = function() {
                container.removeChild(div);
            };
            div.appendChild(input);
            div.appendChild(button);
            container.appendChild(div);
        }
    </script>
@endsection
