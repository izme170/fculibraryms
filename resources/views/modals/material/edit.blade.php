<div class="modal fade" id="editMaterial" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Material</h1>
            </div>
            <div class="modal-body">
                <form action="/material/store" method="post" enctype="multipart/form-data" id="material-form">
                    @csrf
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="issn">ISSN</label>
                                    <input type="text" id="issn" name="issn" value="{{ $material->issn ?? ''}}"
                                        autofocus>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="isbn">ISBN</label>
                                    <input type="text" id="isbn" name="isbn" value="{{ $material->isbn ?? ''}}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" id="title" name="title" value="{{ $material->title ?? ''}}">
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
                                            <option value="{{ $type->type_id }}"
                                                {{ $type->type_id == 1 ? 'selected' : '' }}
                                                {{ $material->type_id == $type->type_id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="publisher">Publisher</label>
                                    <input type="text" id="publisher" name="publisher"
                                        value="{{ $material->publisher->name ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="publication_year">Publication Year</label>
                                    <input type="number" min="1000" max="{{ date('Y') }}" step="1"
                                        placeholder="YYYY" id="publication_year" name="publication_year"
                                        value="{{ $material->publication_year ?? ''}}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="edition">Edition</label>
                                    <input type="text" id="edition" name="edition"
                                        value="{{ $material->edition ?? ''}}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="volume">Volume</label>
                                    <input type="text" id="volume" name="volume"
                                        value="{{ $material->volume ?? ''}}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="pages">Pages</label>
                                    <input type="text" id="pages" name="pages"
                                        value="{{ $material->pages ?? ''}}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="size">Size</label>
                                    <input type="text" id="size" name="size"
                                        value="{{ $material->size ?? ''}}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="includes">Includes</label>
                                    <input type="text" id="includes" name="includes"
                                        value="{{ $material->includes ?? ''}}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="references">References</label>
                                    <input type="text" id="references" name="references"
                                        value="{{ $material->references ?? ''}}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label d-block" for="description">Description</label>
                                    <textarea id="description" name="description" value="{{ $material->description ?? ''}}"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="category_id">Category</label>
                                    <select id="category_id" name="category_id">
                                        <option value="">Select material category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category_id }}"
                                                {{ $material->category_id == $category->category_id ? 'selected' : '' }}>
                                                {{ $category->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="btn-simple btn-right" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn-simple btn-right" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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

    function handleList(listData, inputId, listId, hiddenInputId) {
        let list = Array.isArray(listData) ? [...listData] : [];
        const inputField = document.getElementById(inputId);
        const listElement = document.getElementById(listId);
        const hiddenInput = document.getElementById(hiddenInputId);

        function addItem() {
            if (inputField.value.trim() !== "") {
                list.push(inputField.value.trim());
                updateList();
                inputField.value = "";
            }
        }

        function removeItem(index) {
            list.splice(index, 1);
            updateList();
        }

        function updateList() {
            listElement.innerHTML = "";
            list.forEach((item, index) => {
                const li = document.createElement("li");
                li.className = "item";
                li.innerHTML = `
                    <span>${item}</span>
                    <button class="btn-trash" type="button"><x-lucide-x width="25" /></button>
                `;
                li.querySelector("button").addEventListener("click", () => removeItem(index));
                listElement.appendChild(li);
            });
            hiddenInput.value = JSON.stringify(list);
        }

        document.getElementById("material-form").addEventListener("submit", function () {
            hiddenInput.value = JSON.stringify(list);
        });

        updateList();
        return { addItem };
    }

    const authors = {!! json_encode($material->authors->pluck('name')) !!};
    const editors = {!! json_encode($material->editors->pluck('name')) !!};
    const illustrators = {!! json_encode($material->illustrators->pluck('name')) !!};
    const translators = {!! json_encode($material->translators->pluck('name')) !!};
    const subjects = {!! json_encode($material->subjects->pluck('name')) !!};

    const authorHandler = handleList(authors, 'author', 'authorList', 'authorsInput');
    const editorHandler = handleList(editors, 'editor', 'editorList', 'editorsInput');
    const illustratorHandler = handleList(illustrators, 'illustrator', 'illustratorList', 'illustratorsInput');
    const translatorHandler = handleList(translators, 'translator', 'translatorList', 'translatorsInput');
    const subjectHandler = handleList(subjects, 'subject', 'subjectList', 'subjectsInput');
</script>
