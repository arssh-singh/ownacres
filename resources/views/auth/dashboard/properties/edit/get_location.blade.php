<div class="card border rounded-3 p-3">
    <p class="text-muted mb-3" style="font-size:11px; letter-spacing:.06em">
        Location
    </p>

    <div class="row g-3">

        {{-- City --}}
        <div class="col-md-6">
            <label class="form-label small">City</label>
            <input
                type="text"
                name="city"
                value="{{ old('city', $property->location?->city) }}"
                placeholder="Enter City"
                class="form-control border-0 border-bottom rounded-0 px-0"
                required
            >
        </div>

        {{-- Locality --}}
        <div class="col-md-6">
            <label class="form-label small">Locality / Area</label>
            <input
                type="text"
                name="locality"
                value="{{ old('locality', $property->location?->locality) }}"
                placeholder="Enter Locality"
                class="form-control border-0 border-bottom rounded-0 px-0"
            >
        </div>

        {{-- Postal Code --}}
        <div class="col-md-6">
            <label class="form-label small">Postal Code</label>
            <input
                type="text"
                name="postal_code"
                value="{{ old('postal_code', $property->location?->postal_code) }}"
                placeholder="Postal Code"
                class="form-control border-0 border-bottom rounded-0 px-0"
            >
        </div>

        {{-- Latitude --}}
        <div class="col-md-3">
            <label class="form-label small">Latitude</label>
            <input
                type="text"
                id="latitude"
                name="latitude"
                value="{{ old('latitude', $property->location?->latitude ?? 30.900965) }}"
                class="form-control border-0 border-bottom rounded-0 px-0"
                readonly
            >
        </div>

        {{-- Longitude --}}
        <div class="col-md-3">
            <label class="form-label small">Longitude</label>
            <input
                type="text"
                id="longitude"
                name="longitude"
                value="{{ old('longitude', $property->location?->longitude ?? 75.857276) }}"
                class="form-control border-0 border-bottom rounded-0 px-0"
                readonly
            >
        </div>

        {{-- Full Address --}}
        <div class="col-12">
            <label class="form-label small">Full Address</label>
            <textarea
                name="address"
                rows="3"
                placeholder="House No, Street, Landmark"
                class="form-control border-0 border-bottom rounded-0 px-0"
                required
            >{{ old('address', $property->location?->address) }}</textarea>
        </div>

        {{-- Map --}}
        <div class="col-12 mt-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label small mb-0">
                    Select Location on Map
                </label>

                <button
                    type="button"
                    class="btn btn-sm btn-outline-primary"
                    id="use-current-location"
                >
                    <i class="bi bi-crosshair"></i>
                    Use Current Location
                </button>
            </div>

            <div
                id="map"
                class="border rounded-3 overflow-hidden"
                style="height:350px;"
            ></div>

            <button type="button" id="use-current-location" class="btn btn-outline-primary">
                Use Current Location
            </button>
        </div>

    </div>
    <input type="hidden" name="changed[location]" value="0">
</div>
{{-- map --}}
@push('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Default location (Punjab)
    const defaultLat = parseFloat(document.getElementById('latitude').value) || 30.900965;
    const defaultLng = parseFloat(document.getElementById('longitude').value) || 75.857276;

    // Create map
    const map = L.map('map').setView([defaultLat, defaultLng], 13);

    // OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Marker
    const marker = L.marker([defaultLat, defaultLng], {
        draggable: true
    }).addTo(map);

    const latitude = document.getElementById('latitude');
    const longitude = document.getElementById('longitude');

    function updateLocation(lat, lng) {
        latitude.value = lat.toFixed(6);
        longitude.value = lng.toFixed(6);
        document.querySelector('input[name="changed[location]"]').value = 1;

        marker.setLatLng([lat, lng]);
        map.panTo([lat, lng]);
    }

    // Click on map
    map.on('click', function (e) {
        updateLocation(e.latlng.lat, e.latlng.lng);
    });

    // Drag marker
    marker.on('dragend', function () {
        const pos = marker.getLatLng();
        updateLocation(pos.lat, pos.lng);
    });

    // Use current location button
    const currentLocationBtn = document.getElementById('use-current-location');

    if (currentLocationBtn) {
        currentLocationBtn.addEventListener('click', function () {

            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser.');
                return;
            }

            navigator.geolocation.getCurrentPosition(function (position) {

                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                updateLocation(lat, lng);
                map.setView([lat, lng], 16);

            }, function () {
                alert('Unable to retrieve your current location.');
            });
        });
    }

    // Fix rendering inside Bootstrap cards/tabs
    setTimeout(function () {
        map.invalidateSize();
    }, 300);

    window.addEventListener('resize', function () {
        map.invalidateSize();
    });

});
</script>
@endpush
@push('scripts')
<script>
// selecting by name
const cityInput = document.querySelector('input[name="city"]');
const localityInput = document.querySelector('input[name="locality"]');
const postalCodeInput = document.querySelector('input[name="postal_code"]');
const addressInput = document.querySelector('textarea[name="address"]');  
const latitudeInput = document.querySelector('input[name="latitude"]');
const longitudeInput = document.querySelector('input[name="longitude"]');

const locationfields = [
    cityInput,
    localityInput,
    postalCodeInput,
    addressInput,
    latitudeInput,
    longitudeInput,
];
function markLocationChanged() {
    document.querySelector('input[name="changed[location]"]').value = 1;
}
locationfields.forEach(field => {
    if (!field) return;

    field.addEventListener('input', markLocationChanged);
    field.addEventListener('change', markLocationChanged);
});
</script>
@endpush