@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    <div class="">
        <div class="form-container">
            <form action="/material/store" method="post" enctype="multipart/form-data" id="material-form">
                @csrf
                <div class="col">
                    <div class="row">
                        <div class="col" style="max-width: fit-content;">
                            <div class="mb-3">
                                <label class="form-label" for="material_image">Material Image</label>
                                <input type="file" id="material_image" name="material_image" accept="image/*"
                                    onchange="previewImage(event)" style="display: none;">
                                <img id="imagePreview" src="{{ asset('img/default-material-image.png') }}"
                                    alt="Image Preview"
                                    style="max-width: 200px; display: block; margin-top: 10px; cursor: pointer;"
                                    onclick="document.getElementById('material_image').click();">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="issn">ISSN</label>
                                <input type="text" id="issn" name="issn" value="{{ old('issn') }}" autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="isbn">ISBN</label>
                                <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}" autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="title">Title</label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="col">
                            <input type="text" id="author">
                            <button type="button" onclick="addAuthor()">Add Author</button>
                            <ol id="authorList">
                            </ol>
                            <input type="text" name="authors" id="authorsInput" hidden>
                        </div>
                        {{-- <div class="col">
                            <div>
                                <label class="form-label" for="author">Author</label>
                                <div id="author-container">
                                    <input class="mb-1" type="text" id="author" name="author[]"
                                        value="{{ old('author') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn-rectangle" type="button" onclick="addAuthorInput()">Add Another
                                    Author</button>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="type_id">Material Type</label>
                                <select id="type_id" name="type_id">
                                    <option value="">Select material type</option>
                                    @foreach ($material_types as $type)
                                        <option value="{{ $type->type_id }}"
                                            {{ old('type_id') == $type->type_id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="publisher">Publisher</label>
                                <input type="text" id="publisher" name="publisher" value="{{ old('publisher') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="publication_year">Publication Year</label>
                                <input type="number" min="1000" max="{{ date('Y') }}" step="1"
                                    placeholder="YYYY" id="publication_year" name="publication_year"
                                    value="{{ old('publication_year') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="edition">Edition</label>
                                <input type="text" id="edition" name="edition" value="{{ old('edition') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="volume">Volume</label>
                                <input type="text" id="volume" name="volume" value="{{ old('volume') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="pages">Pages</label>
                                <input type="text" id="pages" name="pages" value="{{ old('pages') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="size">Size</label>
                                <input type="text" id="size" name="size" value="{{ old('size') }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="includes">Includes</label>
                                <input type="text" id="includes" name="includes" value="{{ old('includes') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="references">References</label>
                                <input type="text" id="references" name="references"
                                    value="{{ old('references') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-block" for="description">Description</label>
                                <textarea id="description" name="description" value="{{ old('description') }}"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="category_id">Category</label>
                                <select id="category_id" name="category_id">
                                    <option value="">Select material category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->category_id }}"
                                            {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                            {{ $category->category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn-simple btn-right" type="submit">Submit</button>
                        </div>
                    </div>

                </div>
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

        let authors = [];

        let oldAuthors = {!! json_encode(old('authors') ? old('authors') : []) !!};
        if (oldAuthors.length > 0) {
            authors = oldAuthors;
            updateAuthorList();
        }

        function addAuthor() {
            //get the author from the input
            let author = document.getElementById('author');

            //add the author to the array
            if (author.value.trim() !== "") {
                authors.push(author.value);

                updateAuthorList()

                //clear the input
                author.value = "";
            }
        }

        function updateAuthorList() {
            //get the author list element then clear it
            let authorList = document.getElementById('authorList');
            authorList.innerHTML = "";

            //loop through the array then create a new element then append it to the  author list element
            authors.forEach((author, index) => {
                let li = document.createElement('li');
                li.innerHTML = `
                ${author} <button type="button" onclick="removeAuthor(${index})">Remove</button>`;
                authorList.appendChild(li);
            })
            console.log(authors);
        }

        function removeAuthor(index){
            authors.splice(index, 1);
            updateAuthorList();
        }

        document.getElementById("material-form").addEventListener("submit", function(event){
            document.getElementById("authorsInput").value = JSON.stringify(authors);
        })

        // function addAuthorInput() {
        //     var container = document.getElementById('author-container');
        //     var div = document.createElement('div');
        //     div.className = 'author-input-group mt-2';
        //     var input = document.createElement('input');
        //     input.type = 'text';
        //     input.name = 'author[]';
        //     var button = document.createElement('button');
        //     button.type = 'button';
        //     button.className = 'btn-rectangle btn-sm my-1';
        //     button.innerText = 'Remove';
        //     button.onclick = function() {
        //         container.removeChild(div);
        //     };
        //     div.appendChild(input);
        //     div.appendChild(button);
        //     container.appendChild(div);
        // }
    </script>
@endsection
