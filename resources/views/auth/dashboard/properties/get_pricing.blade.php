@extends('layouts.user')

@section('content')

<div class="mt-5 mb-4">
    <p class="text-muted text-uppercase small fw-semibold mb-1">Step 3 of 4</p>
    <h1 class="fw-light">Set your price</h1>
    <p class="text-muted">Choose whether you're selling or renting, then enter the price.</p>
</div>

<form action="{{ route('properties.pricing.store', $property) }}" method="POST">
    @csrf

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <label class="form-label text-muted small text-uppercase fw-semibold" for="listing_type">Listing Type</label>
            <select
                name="listing_type"
                id="listing_type"
                class="form-select border-0 border-bottom rounded-2 px-2 py-2 fs-5 @error('listing_type') is-invalid @enderror"
            >
                <option value="sale" @selected(old('listing_type', optional($property->pricing)->listing_type) === 'sale')>
                    For Sale
                </option>
                <option value="rent" @selected(old('listing_type', optional($property->pricing)->listing_type) === 'rent')>
                    For Rent
                </option>
            </select>
            @error('listing_type')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-8">
            <label class="form-label text-muted small text-uppercase fw-semibold" id="priceLabel" for="price">Price (₹)</label>
            <div class="input-group @error('price') is-invalid @enderror">
                <span class="input-group-text bg-transparent border-0 border-bottom rounded-2 px-2 py-2 fs-5">₹</span>
                <input
                    type="number"
                    id="price"
                    name="price"
                    value="{{ old('price', optional($property->pricing)->price) }}"
                    placeholder="Enter price"
                    class="form-control border-0 border-bottom rounded-2 px-2 py-2 fs-5 @error('price') is-invalid @enderror"
                    min="0"
                    step="0.01"
                    required
                >
            </div>
            @error('price')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-between">
        <span class="text-muted small">You can edit this later from your dashboard.</span>
        <button type="submit" class="btn btn-dark px-4 py-2">
            Save & Continue →
        </button>
    </div>

</form>

@endsection
@push('scripts')
    <script>
        const option = document.getElementById('listing_type');
        const priceLabel = document.getElementById('priceLabel');
        option.addEventListener('change', function() {
            const priceInput = document.querySelector('input[name="price"]');
            if (this.value === 'sale') {
                priceInput.placeholder = 'Enter sale price';
                priceLabel.textContent = 'Price (₹)';
            } else if (this.value === 'rent') {
                priceInput.placeholder = 'Enter monthly rent';
                priceLabel.textContent = 'Price (₹) Per Month';
            } else {
                priceInput.placeholder = 'Enter price';
                priceLabel.textContent = 'Price (₹)';
            }
        });
    </script>
@endpush