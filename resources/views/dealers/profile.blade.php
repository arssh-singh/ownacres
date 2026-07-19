@extends('layouts.app')
@push('styles')
    <style>
    .dealer-avatar {
        width: 160px;
        height: 160px;
        object-fit: cover;
    }
 
    @media (max-width: 767.98px) {
        .dealer-avatar {
            width: 100px;
            height: 100px;
        }
 
        .dealer-stats {
            justify-content: center;
        }
    }
</style>
@endpush
@section('content')
<div class="container mt-5 pt-5">

    <div class="card border-0" style="background-color: transparent;">
        <div class="card-body p-3 p-md-5">
    
            <div class="row align-items-center">
    
                <div class="col-md-3 text-center mb-4 mb-md-0">
                    <img src="{{ $dealer->profile_image_url }}"
                        class="rounded-circle border shadow dealer-avatar">
                </div>
    
                <div class="col-md-9 px-5 text-center text-md-start">
    
                    <h2 class="fw-bold mb-3">{{ $dealer->name }}</h2>
    
                    <div class="d-flex dealer-stats gap-5 mb-4">
                        <div>
                            <h4 class="fw-bold mb-0">{{ $dealer->properties->count() }}</h4>
                            <small class="text-muted">Properties</small>
                        </div>
                    </div>
    
                    <p class="mb-0">
                        🏡 Real Estate Dealer<br>
                        📍 Helping people find their dream home.<br>
                        💼 Buy • Sell • Rent
                    </p>
    
                </div>
    
            </div>
    
        </div>
    </div>
    <div class="row g-1">

        @forelse($dealer->properties as $property)

            <div class="col-lg-4 col-sm-12 col-md-6">

                <a href="{{ route('properties.prop_details', $property->id) }}"
                class="text-decoration-none text-white">

                    <div class="card border-0 overflow-hidden position-relative shadow-sm rounded-0">

                        <img src="{{ $property->cover_image_url }}"
                            class="w-100 rounded-0"
                            style="aspect-ratio:1/1; object-fit:cover;">

                        <!-- Gradient Overlay -->
                        <div class="position-absolute top-0 start-0 w-100 h-100"
                            style="background: linear-gradient(to top,
                                rgba(0,0,0,.85) 0%,
                                rgba(0,0,0,.45) 45%,
                                rgba(0,0,0,0) 80%);">
                        </div>

                        <!-- Property Details -->
                        <div class="position-absolute bottom-0 start-0 w-100 p-3">

                            <h6 class="fw-bold mb-1 text-truncate text-light">
                                {{ $property->display_title }}
                            </h6>

                            <div class="fs-5 fw-bold text-info mb-2">
                                ₹{{ number_format($property->price) }}
                            </div>

                            <div class="d-flex flex-wrap gap-3 small">

                                @if($property->bedrooms)
                                    <span>🛏 {{ $property->bedrooms }} Bed</span>
                                @endif

                                @if($property->bathrooms)
                                    <span>🛁 {{ $property->bathrooms }} Bath</span>
                                @endif

                                @if($property->area)
                                    <span>📐 {{ number_format($property->area) }} sqft</span>
                                @endif

                            </div>

                        </div>

                    </div>

                </a>

            </div>

        @empty

            <div class="col-12 text-center py-5">
                <h5 class="text-muted">No properties listed yet.</h5>
            </div>

        @endforelse

    </div>

</div>
@endsection