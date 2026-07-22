<div class="card border rounded-3 p-3">
    <p class="text-muted mb-3" style="font-size:11px; letter-spacing:.06em">Pricing</p>
    <div class="mb-3">
        <label class="form-label small">Rent/Sale</label>
        <select
            name="listing_type"
            class="form-select border-0 border-bottom rounded-0 px-0"
        >
            <option value="" disabled>Select Listing Type</option>
            <option value="sale" @selected($property->pricing?->listing_type === 'sale')>
                Sale
            </option>
            <option value="rent" @selected($property->pricing?->listing_type === 'rent')>
                Rent
            </option>
        </select>
    </div>
    <div>
        <label class="form-label small">Pricing</label>
        <input
            type="number"
            name="price"
            value="{{ $property->price }}"
            placeholder="Enter Price"
            class="form-control border-0 border-bottom rounded-0 px-0 fs-2 fw-light"
            min="0"
            required
        >
    </div>
    <input type="hidden" name="changed[pricing]" value="0">
</div>
@push('scripts')
<script>
const listingTypeSelect = document.querySelector('select[name="listing_type"]');
const priceInput = document.querySelector('input[name="price"]');
const pricingfields = [listingTypeSelect, priceInput];
pricingfields.forEach(field => {
    field.addEventListener('input', () => {
        console.log('input event triggered');
        document.querySelector('input[name="changed[pricing]"]').value = '1';
    });
    field.addEventListener('change', () => {
        console.log('change event triggered');
        document.querySelector('input[name="changed[pricing]"]').value = '1';
    });
});
</script>
@endpush