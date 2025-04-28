<div class="modal fade" id="updateFine" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Set Fine</h1>
            </div>
            <div class="modal-body">
                <form action="{{ route("setting.updateFine") }}" method="post" id="updateFine" class="m-0">
                    @csrf
                    @method("PUT")
                    <div class="row mb-3">
                        <div class="col">
                            <label for="fine">Fine</label>
                            <input type="number" name="fine" id="fine"
                                value="{{ $fine }}">
                        </div>
                    </div>
                    <button class="btn-simple btn-right" data-bs-dismiss="modal" type="button">Cancel</button>
                    <button class="btn-simple btn-right" type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
