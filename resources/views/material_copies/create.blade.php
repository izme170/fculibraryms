@extends('layout.main')
@include('include.sidenav')
@section('user-content')
    @include('include.topbar')
    <div class="">
        <div class="form-container">
            <form action="/material/store-copy/{{ $id }}" method="post">
                @csrf
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label" for="copy_number">Copy Number</label>
                        <input type="text" id="copy_number" name="copy_number" value="{{ old('copy_number') }}" autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="accession_number">Accession Number</label>
                        <input type="text" id="accession_number" name="accession_number"
                            value="{{ old('accession_number') }}" autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="call_number">Call Number</label>
                        <input type="text" id="call_number" name="call_number" value="{{ old('call_number') }}"
                            autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="price">Price</label>
                        <input type="text" id="price" name="price" value="{{ old('price') }}" autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="vendor_id">Vendor</label>
                        <select id="vendor_id" name="vendor_id">
                            <option value="">Select Vendor</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->vendor_id }}"
                                    {{ old('vendor_id') == $vendor->vendor_id ? 'selected' : '' }}>
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
                                    {{ old('fund_id') == $fund->fund_id ? 'selected' : '' }}>
                                    {{ $fund->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="date_acquired">Date Acquired</label>
                        <input type="date" id="date_acquired" name="date_acquired" value="{{ old('date_acquired') }}"
                            autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="rfid">Scan material's RFID here to submit</label>
                        <input type="text" id="rfid" name="rfid">
                    </div>
                    <div class="mb-3">
                        <button class="btn-rectangle" type="submit" hidden>Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
