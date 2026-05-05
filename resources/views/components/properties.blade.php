@php $properties = $properties ?? collect(); @endphp
<div class="container-fluid px-lg-5 py-5 ">
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
    <div class="row g-4">
        @foreach ($properties as $property)
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm">
                    <div class="position-relative">
                        <img src="{{asset('storage/' . $property->image)}}"
                            class="card-img-top" style="height:250px; object-fit:cover;">
                        <span class="badge bg-light text-dark position-absolute top-0 start-0 m-3">FOR SALE</span>
                    </div>
                    <div class="card-body">
                        <h5 class="fw-bold">${{ number_format($property->price, 2) }}</h5>
                        <p class="text-muted">{{ $property->title }}</p>
                        <p class="text-muted">{{ $property->address}}</p>
                        <div class="d-flex justify-content-between small text-muted">
                            <span>🛏️{{$property->bedrooms}}</span><span>🚻{{$property->bathrooms}}</span><span>7200 sqft</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
