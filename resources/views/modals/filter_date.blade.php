<div class="modal fade" id="filterDate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Filter Date</h1>
            </div>
            <div class="modal-body">
                <form method="GET" id="filterDate" class="m-0">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="startDate">Start</label>
                            <input type="date" name="startDate" id="startDate" class="form-control"
                                value="{{ $startDate }}">
                        </div>
                        <div class="col">
                            <label for="endDate">End</label>
                            <input type="date" name="endDate" id="endDate" class="form-control"
                                value="{{ $endDate }}">
                        </div>
                    </div>
                    <button class="btn-simple btn-right" data-bs-dismiss="modal" type="button">Cancel</button>
                    <button class="btn-simple btn-right" type="submit">Filter</button>
                </form>
            </div>
        </div>
    </div>
</div>
