<div class="modal fade" id="archiveBook" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Archive Book?</h1>
            </div>
            <div class="modal-body">
                <form action="/book/archive/{{ $book->book_id }}" method="post">
                    @csrf
                    @method('PUT')
                    <p>Are you sure you want to archive the book '{{$book->title}}'?</p>
                    <div class="d-flex flex-row justify-content-end gap-1">
                        <button class="btn-simple bg-red" type="button" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
                        <button class="btn-simple" type="submit">Archive</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
