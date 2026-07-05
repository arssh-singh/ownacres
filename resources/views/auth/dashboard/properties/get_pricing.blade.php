@extends('layouts.user')

@section('content')

<div class="mt-5">
    <h1 class="fw-light mb-5">Enter Pricing Details</h1>
</div>

<form action="{{ route('properties.pricing.store', $property) }}" method="POST">
    @csrf

    <div class="mb-5">
        @error('listing_type')
            <div class="text-danger small mt-2">
                {{ $message }}
            </div>
        @enderror
        <label class="form-label text-muted">Listing Type</label>

        <select
            name="listing_type"
            class="form-select border-0 border-bottom rounded-0 px-0"
            id="listing_type"
        >
            <option value="sale" @selected(old('listing_type', optional($property->pricing)->listing_type) === 'sale')>
                Sale
            </option>
            <option value="rent" @selected(old('listing_type', optional($property->pricing)->listing_type) === 'rent')>
                Rent
            </option>
        </select>
    </div>

    <div class="mb-5">
        @error('price')
            <div class="text-danger small mt-2">
                {{ $message }}
            </div>
        @enderror
        <label class="form-label text-muted" id="priceLabel">Price (₹)</label>
        <div class="input-group">
            <span class="input-group-text">₹</span>
            <input
                type="number"
                name="price"
                value=""
                placeholder="Enter Price"
                class="form-control border-0 border-bottom rounded-0 px-0 fs-2 fw-light"
                min="0"
                step="0.01"
                required
                value="{{ old('price', optional($property->pricing)->price) }}"
            >
        </div>

    </div>

    <button type="submit" class="btn btn-dark px-4">
        Continue
    </button>

</form>

@endsection
@push('scripts')
    <script>
        const option = document.getElementById('listing_type');
        const priceLabel = document.getElementById('priceLabel');
        option.addEventListener('change', function() {
            const priceInput = document.querySelector('input[name="price"]');
            if (this.value === 'sale') {
                priceInput.placeholder = 'Enter Sale Price';
                priceLabel.textContent = 'Price (₹)';
            } else if (this.value === 'rent') {
                priceInput.placeholder = 'Enter Rent Price Per Month';
                priceLabel.textContent = 'Price (₹) Per Month';
            } else {
                priceInput.placeholder = 'Enter Price';
                priceLabel.textContent = 'Price (₹)';
            }
        });
    </script>
@endpush