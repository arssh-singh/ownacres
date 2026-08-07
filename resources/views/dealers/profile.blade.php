@extends('layouts.app')
@push('styles')
    <style>
    .dealer-avatar {
        width: 160px;
        height: 160px;
        object-fit: cover;
    }

    .dealer-stat-divider {
        width: 1px;
        background: rgba(0,0,0,.1);
    }

    .property-card {
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .property-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,.18) !important;
    }

    .property-card img {
        transition: transform .4s ease;
    }

    .property-card:hover img {
        transform: scale(1.05);
    }

    .property-meta-pill {
        background: rgba(255,255,255,.12);
        backdrop-filter: blur(4px);
        border-radius: 4px;
        padding: 2px 8px;
        font-size: .8rem;
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

                <div class="col-md-9 px-md-5 text-center text-md-start">

                    <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2 mb-2">
                        <h2 class="fw-bold mb-0">{{ $dealer->name }}</h2>
                        @if($dealer->profile?->is_verified ?? false)
                            <i class="bi bi-patch-check-fill text-info fs-5" title="Verified Dealer"></i>
                        @endif
                    </div>

                    @if($dealer->profile?->headline)
                        <p class="text-muted mb-3 fs-6">{{ $dealer->profile->headline }}</p>
                    @endif

                    <div class="d-flex dealer-stats align-items-center gap-4 mb-4">
                        <div>
                            <h4 class="fw-bold mb-0">{{ $dealer->properties->count() }}</h4>
                            <small class="text-muted text-uppercase" style="font-size: .72rem; letter-spacing: .04em;">Properties</small>
                        </div>

                        @if($dealer->created_at)
                            <div class="dealer-stat-divider" style="height: 36px;"></div>
                            <div>
                                <h4 class="fw-bold mb-0">{{ $dealer->created_at->diffForHumans(null, true) }}</h4>
                                <small class="text-muted text-uppercase" style="font-size: .72rem; letter-spacing: .04em;">On OWNACRES</small>
                            </div>
                        @endif
                    </div>

                    @if($dealer->profile?->bio)
                        <p class="mb-4 text-muted">{{ $dealer->profile->bio }}</p>
                    @endif

                    <div class="d-flex gap-2 justify-content-center justify-content-md-start">
                        @if($dealer->phone)
                            <a href="tel:{{ $dealer->phone }}" class="btn btn-outline-dark btn-sm px-3">
                                <i class="bi bi-telephone me-1"></i> Call
                            </a>
                        @endif
                        {{-- <a href="#" class="btn btn-dark btn-sm px-3">
                            <i class="bi bi-chat-dots me-1"></i> Message
                        </a> --}}
                    </div>

                </div>

            </div>

        </div>
    </div>

    <hr class="my-4">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0">Listings by {{ $dealer->name }}</h5>
        <span class="text-muted small">{{ $dealer->properties->count() }} {{ Str::plural('property', $dealer->properties->count()) }}</span>
    </div>

    <div class="row g-3">

        @forelse($dealer->properties as $property)

            <div class="col-lg-4 col-sm-12 col-md-6">

                <a href="{{ route('properties.prop_details', $property->id) }}"
                class="text-decoration-none text-white">

                    <div class="card property-card border-0 overflow-hidden position-relative shadow-sm">

                        <img src="{{ $property->cover_image_url }}"
                            class="w-100"
                            style="aspect-ratio:1/1; object-fit:cover;">

                        <!-- Gradient Overlay -->
                        <div class="position-absolute top-0 start-0 w-100 h-100"
                            style="background: linear-gradient(to top,
                                rgba(0,0,0,.85) 0%,
                                rgba(0,0,0,.45) 45%,
                                rgba(0,0,0,0) 80%);">
                        </div>

                        @if($property->status === 'published' && $property->created_at?->gt(now()->subDays(7)))
                            <span class="position-absolute top-0 end-0 m-2 badge bg-info text-dark">New</span>
                        @endif

                        <!-- Property Details -->
                        <div class="position-absolute bottom-0 start-0 w-100 p-3">

                            <h6 class="fw-bold mb-1 text-truncate text-light">
                                {{ $property->display_title }}
                            </h6>

                            <div class="fs-5 fw-bold text-info mb-2">
                                ₹{{ number_format($property->price) }}
                            </div>

                            <div class="d-flex flex-wrap gap-2">

                                @if($property->bedrooms)
                                    <span class="property-meta-pill">
                                        <i class="bi bi-door-closed me-1"></i>{{ $property->bedrooms }} Bed
                                    </span>
                                @endif

                                @if($property->bathrooms)
                                    <span class="property-meta-pill">
                                        <i class="bi bi-droplet me-1"></i>{{ $property->bathrooms }} Bath
                                    </span>
                                @endif

                                @if($property->area)
                                    <span class="property-meta-pill">
                                        <i class="bi bi-arrows-angle-expand me-1"></i>{{ number_format($property->area) }} sqft
                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>

                </a>

            </div>

        @empty

            <div class="col-12 text-center py-5">
                <i class="bi bi-house-x fs-1 text-muted d-block mb-2"></i>
                <h5 class="text-muted">No properties listed yet.</h5>
            </div>

        @endforelse

    </div>

</div>
@endsection