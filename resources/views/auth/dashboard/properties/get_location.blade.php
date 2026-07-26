@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
@endpush

@section('content')

<div class="mt-5 mb-4">
    <p class="text-muted text-uppercase small fw-semibold mb-1">Step 4 of 4</p>
    <h1 class="fw-light">Where is it located?</h1>
    <p class="text-muted">Add the address and drop a pin so buyers can find it on the map.</p>
</div>

{{-- TODO: point this at your actual route name/model binding --}}
<form method="POST" action="{{ route('properties.location.store', $property ?? null) }}">
    @csrf

    {{-- Address fields --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <label class="form-label text-muted small text-uppercase fw-semibold" for="city">City</label>
            <input
                type="text"
                id="city"
                name="city"
                value="{{ old('city') }}"
                placeholder="Ludhiana"
                class="form-control border-0 border-bottom rounded-2 px-2 py-2 fs-5 @error('city') is-invalid @enderror"
                required
            >
            @error('city')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label text-muted small text-uppercase fw-semibold" for="locality">Locality / Area</label>
            <input
                type="text"
                id="locality"
                name="locality"
                value="{{ old('locality') }}"
                placeholder="Model Town"
                class="form-control border-0 border-bottom rounded-2 px-2 py-2 fs-5 @error('locality') is-invalid @enderror"
            >
            @error('locality')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label text-muted small text-uppercase fw-semibold" for="postal_code">Postal Code</label>
            <input
                type="text"
                id="postal_code"
                name="postal_code"
                value="{{ old('postal_code') }}"
                placeholder="141001"
                class="form-control border-0 border-bottom rounded-2 px-2 py-2 fs-5 @error('postal_code') is-invalid @enderror"
            >
            @error('postal_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label text-muted small text-uppercase fw-semibold" for="address">Full Address</label>
            <textarea
                id="address"
                name="address"
                rows="3"
                placeholder="House No, Street, Landmark"
                class="form-control border-0 border-bottom rounded-2 px-2 py-2 @error('address') is-invalid @enderror"
                style="resize: none"
                required
            >{{ old('address') }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Map section --}}
    <div class="d-flex justify-content-between align-items-center mt-5 mb-3 flex-wrap">
        <div>
            <p class="text-muted text-uppercase small fw-semibold mb-1">Pin the location</p>
            <p class="text-muted mb-0 small">Click anywhere or drag the marker to set the exact spot.</p>
        </div>

        <button class="btn btn-outline-dark btn-sm mt-2 mt-md-0" type="button" id="use-current-location">
            <i class="bi bi-crosshair me-1"></i>
            Use Current Location
        </button>
    </div>

    <div id="map" class="rounded-2 border overflow-hidden" style="height:450px;"></div>

    {{-- Marker coordinates, kept in sync by the map script below --}}
    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', 30.900965) }}">
    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', 75.857276) }}">

    <div class="d-flex align-items-center justify-content-between mt-4">
        <span class="text-muted small">You can edit this later from your dashboard.</span>
        <button type="submit" class="btn btn-dark px-4 py-2">
            Save & Continue →
        </button>
    </div>
</form>

@endsection
{{-- for map --}}
@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        (function () {
            const DEFAULT_LAT = 30.900965;
            const DEFAULT_LNG = 75.857276;
            const DEFAULT_ZOOM = 13;
            const RESIZE_FIX_DELAY_MS = 200;

            function initMap() {
                const map = L.map('map').setView([DEFAULT_LAT, DEFAULT_LNG], DEFAULT_ZOOM);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap'
                }).addTo(map);

                const marker = L.marker([DEFAULT_LAT, DEFAULT_LNG], {
                    draggable: true
                }).addTo(map);

                const latitudeInput = document.getElementById('latitude');
                const longitudeInput = document.getElementById('longitude');

                function syncCoordsToForm(latlng) {
                    latitudeInput.value = latlng.lat;
                    longitudeInput.value = latlng.lng;
                }

                map.on('click', function (e) {
                    marker.setLatLng(e.latlng);
                    syncCoordsToForm(e.latlng);
                });

                marker.on('dragend', function () {
                    syncCoordsToForm(marker.getLatLng());
                });

                // Fix Leaflet rendering on responsive layouts
                setTimeout(() => map.invalidateSize(), RESIZE_FIX_DELAY_MS);
                window.addEventListener('resize', () => map.invalidateSize());
            }

            initMap();
        })();
    </script>
@endpush