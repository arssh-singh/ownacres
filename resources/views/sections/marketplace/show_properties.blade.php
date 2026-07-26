@php $properties = $properties ?? collect(); @endphp
<div class="container-fluid px-lg-5 ">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <small class="text-primary fw-semibold text-uppercase">Archive Selection</small>
            <h2 class="fw-bold">Curated Properties</h2>
        </div>
        <a href="#" class="text-decoration-none text-dark fw-semibold small">
            VIEW ALL LISTINGS
        </a>
    </div>

    <!-- Cards -->
    <div class="row g-2">
        @foreach ($properties as $property)
            <div class="col-lg-3 property-card" onclick="window.location.href='{{ route('properties.prop_details', $property->id) }}'" style="cursor:pointer;">
                <div class="card border-0 shadow-sm">
                    <div class="position-relative">
                        <img src="{{asset('storage/' . $property->coverImage?->file_path)}}"
                            class="card-img-top hero-image" style="height:250px; object-fit:cover;" >
                        <span class="badge bg-light text-dark position-absolute top-0 start-0 m-3">{{ $property->pricing->listing_type }}</span>
                    </div>
                    <div class="card-body">
                        <h5 class="fw-bold ">₹{{ number_format($property->price, 2) }}</h5>
                        <p class="fw-semibold text-dark mb-1">
                            {{ \Illuminate\Support\Str::limit($property->display_title, 20, '...') }}
                        </p>

                        <p class="text-muted mb-0">
                            {{ \Illuminate\Support\Str::limit($property->display_description, 15, '...') }}
                        </p>
                        {{-- <div class="d-flex justify-content-between small text-muted">
                            <span>🛏️{{$property->bedrooms}}</span><span>🚻{{$property->bathrooms}}</span><span>7200 sqft</span>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- <div class="mt-4 d-flex justify-content-center">
        {{ $properties }}
    </div> --}}
</div>