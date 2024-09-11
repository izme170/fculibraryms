<div class="modal fade" id="editBook" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Book</h1>
            </div>
            <div class="modal-body">
                <form action="/book/update/{{ $book->book_id }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" id="title" name="title" value="{{ $book->title }}" autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="author">Author</label>
                        <input type="text" id="author" name="author" value="{{ $book->author }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="category_id">category</label>
                        <select id="category_id" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}" {{$book->category_id == $category->category_id ? 'selected' : ''}}>
                                    {{ $category->category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex flex-row justify-content-end gap-1">
                        <button class="btn-simple bg-red" type="button" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
                        <button class="btn-simple" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
