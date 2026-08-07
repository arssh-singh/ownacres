@extends('layouts.app')
@push('styles')
    <style>
    .dealer-card {
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .dealer-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,.12) !important;
    }

    .dealer-avatar-sm {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }

    .dealer-bio-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    </style>
@endpush
@section('content')
<div class="container py-5 mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Property Dealers</h2>
            <p class="text-muted mb-0">
                Browse verified property dealers on OwnAcres.
            </p>
        </div>

        <span class="badge bg-primary fs-6">
            {{ $dealers->count() }} Dealers
        </span>
    </div>

    <div class="row g-4">

        @forelse($dealers as $dealer)

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                <div class="card dealer-card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body text-center d-flex flex-column">

                        <div class="position-relative d-inline-block mx-auto mb-3">
                            <img src="{{ $dealer->profile_image_url }}"
                                alt="{{ $dealer->name }}"
                                class="rounded-circle shadow-sm dealer-avatar-sm"
                                width="100"
                                height="100">

                            @if($dealer->profile?->is_verified ?? false)
                                <i class="bi bi-patch-check-fill text-info position-absolute bottom-0 end-0 bg-white rounded-circle"
                                style="font-size: 1.1rem;"
                                title="Verified Dealer"></i>
                            @endif
                        </div>

                        <h5 class="fw-bold mb-1">
                            {{ $dealer->name }}
                        </h5>

                        <p class="text-muted small mb-2">
                            {{ $dealer->profile?->headline ?? 'Real Estate Dealer' }}
                        </p>

                        @if($dealer->profile?->bio)
                            <p class="text-muted small mb-3 dealer-bio-clamp">
                                {{ $dealer->profile->bio }}
                            </p>
                        @endif

                        <div class="d-flex justify-content-center gap-3 small text-muted mb-3">
                            <span>
                                <i class="bi bi-houses me-1"></i>{{ $dealer->properties_count ?? $dealer->properties->count() }} listings
                            </span>
                            @if($dealer->profile?->city)
                                <span>
                                    <i class="bi bi-geo-alt me-1"></i>{{ $dealer->profile->city }}
                                </span>
                            @endif
                        </div>

                        <a href="{{ route('dealer.profile', $dealer->id) }}"
                        class="btn btn-primary rounded-pill px-4 mt-auto">
                            View Profile
                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-light border text-center py-5">
                    <i class="bi bi-person-x fs-1 text-muted d-block mb-2"></i>
                    <h5 class="mb-2">No dealers found</h5>
                    <p class="text-muted mb-0">
                        There are currently no registered property dealers.
                    </p>
                </div>
            </div>

        @endforelse

    </div>

</div>
@endsection