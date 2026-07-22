@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="card border-0 rounded-4 bg-transparent">
            <div class="card-body p-3 p-md-4 p-lg-5">

                {{-- Header --}}
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-danger bg-opacity-10 rounded-circle px-4 p-3 me-3">
                        <i class="bi bi-geo-alt-fill text-danger fs-4"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1">Property Location</h3>
                        <p class="text-muted mb-0">
                            Add the property's address and pinpoint its exact location on the map.
                        </p>
                    </div>
                </div>

                {{-- TODO: point this at your actual route name/model binding --}}
                <form method="POST" action="{{ route('properties.location.store', $property ?? null) }}">
                    @csrf

                    {{-- Address fields --}}
                    <div class="row g-4">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label fw-semibold">City</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-buildings"></i>
                                </span>
                                <input type="text" class="form-control" name="city" placeholder="Ludhiana" value="{{ old('city') }}" required>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label fw-semibold">Locality / Area</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-pin-map"></i>
                                </span>
                                <input type="text" class="form-control" name="locality" placeholder="Model Town" value="{{ old('locality') }}">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label fw-semibold">Postal Code</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-mailbox"></i>
                                </span>
                                <input type="text" class="form-control" name="postal_code" placeholder="141001" value="{{ old('postal_code') }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Full Address</label>
                            <textarea rows="3" class="form-control" name="address" placeholder="House No, Street, Landmark" required>{{ old('address') }}</textarea>
                        </div>
                    </div>

                    {{-- Map section --}}
                    <div class="d-flex justify-content-between align-items-center mt-5 mb-3 flex-wrap">
                        <div>
                            <h5 class="fw-bold mb-1">Select Property on Map</h5>
                            <small class="text-muted">
                                Click anywhere or drag the marker to set the exact location.
                            </small>
                        </div>

                        <button class="btn btn-outline-primary mt-3 mt-md-0" type="button" id="use-current-location">
                            <i class="bi bi-crosshair me-2"></i>
                            Use Current Location
                        </button>
                    </div>

                    <div id="map" class="rounded-4 border shadow-sm overflow-hidden" style="height:500px;"></div>

                    {{-- Marker coordinates, kept in sync by the map script below --}}
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', 30.900965) }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', 75.857276) }}">

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            Save &amp; Continue
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
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
