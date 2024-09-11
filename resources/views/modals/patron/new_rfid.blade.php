<div class="modal fade" id="newPatronRFID" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Assign new RFID to patron.</h1>
            </div>
            <div class="modal-body">
                <form action="/patron/new_rfid/{{ $patron->patron_id }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="library_id">New RFID</label>
                        <input type="text" id="library_id" name="library_id" autofocus>
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
