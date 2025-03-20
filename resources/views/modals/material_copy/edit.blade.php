<div class="modal fade" id="editMaterialCopy" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Copy</h1>
            </div>
            <div class="modal-body">
                <form action="/material/update/copy/{{ $copy->copy_id }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="copy_number">Copy Number</label>
                            <input type="text" id="copy_number" name="copy_number"
                                value="{{ $copy->copy_number ?? '' }}" autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="accession_number">Accession Number</label>
                            <input type="text" id="accession_number" name="accession_number"
                                value="{{ $copy->accession_number ?? '' }}" autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="call_number">Call Number</label>
                            <input type="text" id="call_number" name="call_number"
                                value="{{ $copy->call_number ?? '' }}" autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="price">Price</label>
                            <input type="text" id="price" name="price" value="{{ $copy->price ?? '' }}"
                                autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="vendor_id">Vendor</label>
                            <select id="vendor_id" name="vendor_id">
                                <option value="">Select Vendor</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->vendor_id }}"
                                        {{ $copy->vendor_id == $vendor->vendor_id ? 'selected' : '' }}>
                                        {{ $vendor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="fund_id">Fund</label>
                            <select id="fund_id" name="fund_id">
                                <option value="">Select fund</option>
                                @foreach ($funds as $fund)
                                    <option value="{{ $fund->fund_id }}"
                                        {{ $copy->fund_id == $fund->fund_id ? 'selected' : '' }}>
                                        {{ $fund->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="date_acquired">Date Acquired</label>
                            <input type="date" id="date_acquired" name="date_acquired"
                                value=" {{ $copy->date_acquired ?? '' }}" autofocus>
                        </div>
                        <button class="btn-simple btn-right" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn-simple btn-right" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
