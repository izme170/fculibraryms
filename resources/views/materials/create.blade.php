@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    <div class="bg-white p-3 rounded" style="min-width: fit-content">
        <a href="{{ route('materials.index') }}" class="text-decoration-none text-dark">
            <x-lucide-arrow-left width="30" class="mb-2" />
        </a>
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
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <label class="form-label" for="author">Author</label>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" id="author">
                                    </div>
                                    <div class="col p-0" style="max-width: fit-content;">
                                        <button class="btn-add" type="button"
                                            onclick="authorHandler.addItem()">Add</button>
                                    </div>
                                </div>
                                <ol class="list-item" id="authorList">
                                </ol>
                                <input type="text" name="authors" id="authorsInput" hidden>
                            </div>
                            <div class="row">
                                <label class="form-label" for="editor">Editor</label>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" id="editor">
                                    </div>
                                    <div class="col p-0" style="max-width: fit-content;">
                                        <button class="btn-add" type="button"
                                            onclick="editorHandler.addItem()">Add</button>
                                    </div>
                                </div>
                                <ol class="list-item" id="editorList">
                                </ol>
                                <input type="text" name="editors" id="editorsInput" hidden>
                            </div>
                            <div class="row">
                                <label class="form-label" for="illustrator">Illustrator</label>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" id="illustrator">
                                    </div>
                                    <div class="col p-0" style="max-width: fit-content;">
                                        <button class="btn-add" type="button"
                                            onclick="illustratorHandler.addItem()">Add</button>
                                    </div>
                                </div>
                                <ol class="list-item" id="illustratorList">
                                </ol>
                                <input type="text" name="illustrators" id="illustratorsInput" hidden>
                            </div>
                            <div class="row">
                                <label class="form-label" for="translator">Translator</label>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" id="translator">
                                    </div>
                                    <div class="col p-0" style="max-width: fit-content;">
                                        <button class="btn-add" type="button"
                                            onclick="translatorHandler.addItem()">Add</button>
                                    </div>
                                </div>
                                <ol class="list-item" id="translatorList">
                                </ol>
                                <input type="text" name="translators" id="translatorsInput" hidden>
                            </div>
                            <div class="row">
                                <label class="form-label" for="subject">Subject</label>
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="text" id="subject">
                                    </div>
                                    <div class="col p-0" style="max-width: fit-content;">
                                        <button class="btn-add" type="button"
                                            onclick="subjectHandler.addItem()">Add</button>
                                    </div>
                                </div>
                                <ol class="list-item" id="subjectList">
                                </ol>
                                <input type="text" name="subjects" id="subjectsInput" hidden>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="type_id">Material Type</label>
                                <select id="type_id" name="type_id">
                                    @foreach ($material_types as $type)
                                        <option value="{{ $type->type_id }}" {{ $type->type_id == 1 ? 'selected' : '' }}
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
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="size">Size</label>
                                <input type="text" id="size" name="size" value="{{ old('size') }}">
                            </div>
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

        function handleList(listName, inputId, listId, hiddenInputId) {
            let list = [];

            // Fetch old input data for the specific list
            let oldList = {!! json_encode(old('listName') ? old('listName') : []) !!};
            if (oldList.length > 0) {
                list = oldList;
                updateList();
            }

            function addItem() {
                let item = document.getElementById(inputId);

                if (item.value.trim() !== "") {
                    list.push(item.value);
                    updateList();
                    item.value = "";
                }
            }

            function updateList() {
                let listElement = document.getElementById(listId);
                listElement.innerHTML = "";

                list.forEach((item, index) => {
                    let li = document.createElement('li');
                    li.className = 'item';
                    li.innerHTML = `
                        <span>${item}</span>
                        <button class="btn-trash" type="button"><x-lucide-x width="25" /></button>
                    `;
                    li.querySelector('button').addEventListener('click', () => removeItem(index));
                    listElement.appendChild(li);
                });
            }

            function removeItem(index) {
                list.splice(index, 1);
                updateList();
            }

            document.getElementById("material-form").addEventListener("submit", function(event) {
                document.getElementById(hiddenInputId).value = JSON.stringify(list);
            });

            return {
                addItem,
                removeItem
            };
        }

        const authorHandler = handleList('authors', 'author', 'authorList', 'authorsInput');
        const editorHandler = handleList('editors', 'editor', 'editorList', 'editorsInput');
        const illustratorHandler = handleList('illustrators', 'illustrator', 'illustratorList', 'illustratorsInput');
        const translatorHandler = handleList('translators', 'translator', 'translatorList', 'translatorsInput');
        const subjectHandler = handleList('subjects', 'subject', 'subjectList', 'subjectsInput');
    </script>
@endsection
