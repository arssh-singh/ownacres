@extends('layouts.app')
@section('content')

@php
    $title = $property->display_title;
    $description = $property->display_description;
    $coverImage = $property->cover_image_url;
    $media = $property->media;
    $price = $property->price;
@endphp
<!-- Breadcrumb + Actions -->
<div class="container-fluid px-lg-5 px-3 pt-5 mt-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('marketplace') }}" class="text-decoration-none">Properties</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width: 200px;">{{ $title }}</li>
            </ol>
        </nav>

        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" id="shareBtn">
                <i class="bi bi-share"></i> Share
            </button>
            @auth
                <button class="btn btn-outline-danger btn-sm rounded-pill px-3" id="saveBtn">
                    <i class="bi bi-heart"></i> Save
                </button>
            @endauth
        </div>
    </div>
</div>

<!-- Gallery -->
<div class="container-fluid px-lg-5 px-3 py-4">
    <div class="row g-3">
        <div class="col-lg-8">
            <img 
                id="mainImage"
                src="{{ $coverImage }}"
                class="w-100 h-100 rounded-4 object-fit-cover"
                style="min-height: 400px; max-height: 620px; cursor: pointer; view-transition-name: poster"
                alt="{{ $title }}"
                data-bs-toggle="modal"
                data-bs-target="#galleryModal"
            >
        </div>

        <div class="col-lg-4">
            <div class="row g-3 h-100">
                @php
                    $thumbs = $property->media ?? collect();
                @endphp

                @forelse ($thumbs->take(2) as $i => $img)
                    <div class="col-12" style="height: 50%;">
                        <img 
                            src="{{ asset('storage/' . $img->file_path) }}"
                            class="w-100 h-100 rounded-4 object-fit-cover thumb-img"
                            style="min-height: 200px; cursor: pointer;"
                            alt=""
                            data-bs-toggle="modal"
                            data-bs-target="#galleryModal"
                        >
                    </div>
                @empty
                    <div class="col-12" style="height: 50%;">
                        <img src="https://picsum.photos/600/400?random=2" class="w-100 h-100 rounded-4 object-fit-cover" style="min-height: 200px;" alt="">
                    </div>
                    <div class="col-12" style="height: 50%;">
                        <img src="https://picsum.photos/600/400?random=3" class="w-100 h-100 rounded-4 object-fit-cover" style="min-height: 200px;" alt="">
                    </div>
                @endforelse

                @if ($thumbs->count() > 2)
                    <div class="col-12 position-relative" style="height: 0;">
                        <button class="btn btn-dark btn-sm position-absolute bottom-0 end-0 m-3 rounded-pill"
                                data-bs-toggle="modal" data-bs-target="#galleryModal" style="z-index:2;">
                            <i class="bi bi-images"></i> +{{ $thumbs->count() - 2 }} photos
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Title / Price / Quick Stats -->
<div class="container-fluid px-lg-5 px-3 py-1 mb-2">
    <div class="row g-4 align-items-center">
        <div class="col-lg-8">
            <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 mb-2">
                {{ $property->status ?? 'For Sale' }}
            </span>
            <h1 class="fw-bold display-5 m-0">{{ $title }}</h1>
            <p class="text-muted mt-2 mb-0">
                <i class="bi bi-geo-alt-fill text-primary"></i> {{ $property->location->city }}
            </p>
        </div>

        <div class="col-lg-4 text-lg-end">
            <h2 class="fw-bold display-6 text-primary mb-3">
                ₹{{ number_format($price, 2) }}
            </h2>
            <div class="d-flex gap-3 justify-content-lg-end flex-wrap">
                <span class="d-flex align-items-center gap-1 text-muted">
                    <i class="bi bi-textarea fs-5"></i> {{ $property->area }} sqft
                </span>
                <span class="d-flex align-items-center gap-1 text-muted">
                    <i class="bi bi-door-open-fill fs-5"></i> {{ $property->bedrooms }} Beds
                </span>
                <span class="d-flex align-items-center gap-1 text-muted">
                    <i class="bi bi-droplet-fill fs-5"></i> {{ $property->bathrooms }} Baths
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Details, Map & Inquiry -->
<div class="container-fluid px-lg-5 px-3 py-5 bg-light">
    <div class="row g-4">

        <!-- Left: Description + Amenities + Map -->
        <div class="col-lg-8">

            <div class="bg-white rounded-4 p-4 p-lg-5 shadow-sm mb-4">
                <h2 class="fw-bold mb-3">Property Details</h2>
                <p class="text-muted lh-lg">{{ $description }}</p>

                <hr class="my-4">

                {{-- <h5 class="fw-bold mb-3">Overview</h5>
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <div class="border rounded-3 p-3 text-center h-100">
                            <i class="bi bi-textarea fs-3 text-primary"></i>
                            <p class="mb-0 mt-2 small text-muted">Area</p>
                            <p class="fw-semibold mb-0">{{ $property->area }} sqft</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="border rounded-3 p-3 text-center h-100">
                            <i class="bi bi-door-open-fill fs-3 text-primary"></i>
                            <p class="mb-0 mt-2 small text-muted">Bedrooms</p>
                            <p class="fw-semibold mb-0">{{ $property->bedrooms }}</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="border rounded-3 p-3 text-center h-100">
                            <i class="bi bi-droplet-fill fs-3 text-primary"></i>
                            <p class="mb-0 mt-2 small text-muted">Bathrooms</p>
                            <p class="fw-semibold mb-0">{{ $property->bathrooms }}</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="border rounded-3 p-3 text-center h-100">
                            <i class="bi bi-calendar-event fs-3 text-primary"></i>
                            <p class="mb-0 mt-2 small text-muted">Listed</p>
                            <p class="fw-semibold mb-0">{{ $property->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div> --}}

                @if (!empty($property->amenities))
                    <hr class="my-4">
                    <h5 class="fw-bold mb-3">Amenities</h5>
                    <div class="row g-2">
                        @foreach ($property->amenities as $amenity)
                            <div class="col-6 col-md-4">
                                <span class="d-flex align-items-center gap-2 text-muted">
                                    <i class="bi bi-check-circle-fill text-success"></i> {{ $amenity }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Location / Map -->
            <div class="bg-white rounded-4 p-4 p-lg-5 shadow-sm">
                <h5 class="fw-bold mb-3"><i class="bi bi-map text-primary"></i> Location</h5>
                <div class="rounded-3 overflow-hidden" style="height: 320px;">
                @if($property->location)
                    @php
                        $location = $property->location;

                        if ($location->latitude && $location->longitude) {
                            $mapUrl = "https://maps.google.com/maps?q={$location->latitude},{$location->longitude}&output=embed";
                        } else {
                            $query = $location->address
                                ?: ($location->locality . ', ' . $location->city);

                            $mapUrl = "https://maps.google.com/maps?q=" . urlencode($query) . "&output=embed";
                        }
                    @endphp

                    <iframe
                        class="w-100 h-100 border-0"
                        loading="lazy"
                        src="{{ $mapUrl }}">
                    </iframe>
                @endif
                </div>
            </div>

        </div>

        <!-- Right: Sticky Agent + Inquiry Card -->
        <div class="col-lg-4">
            <div class="bg-white rounded-4 p-4 shadow-sm" style="position: sticky; top: 100px;">

                @if (!empty($property->agent))
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <img src="{{ asset('storage/' . $property->agent->avatar) }}"
                             class="rounded-circle object-fit-cover" style="width:56px; height:56px;" alt="">
                        <div>
                            <p class="fw-bold mb-0">{{ $property->agent->name }}</p>
                            <p class="text-muted small mb-0">Listing Agent</p>
                        </div>
                    </div>
                    <hr class="my-3">
                @endif

                <h5 class="fw-bold mb-3">Interested in this property?</h5>
                <p class="text-muted small mb-4">
                    Send an inquiry and our team will get back to you shortly with more details and a viewing schedule.
                </p>

                @auth
                    <form action="{{ route('properties.save', $property->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-primary w-100 py-3 fw-semibold mb-2">
                            <i class="bi bi-bookmark me-2"></i>
                            {{ auth()->user()->savedProperties->contains($property->id) ? 'Saved' : 'Save' }}
                        </button>
                    </form>
                    <form action="{{ route('dashboard.chat.start', $property->id) }}" method="POST">
                        @csrf
                        @method('POST') 
                        <textarea
                            name="message"
                            class="form-control mb-3"
                            rows="4"
                            placeholder="I'm interested in this property..."></textarea>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold mb-2">
                            <i class="bi bi-send-fill me-2"></i> Send Inquiry
                        </button>
                    </form>
                    {{-- <button class="btn btn-outline-primary w-100 py-3 fw-semibold">
                        <i class="bi bi-telephone-fill me-2"></i> Request a Call Back
                    </button> --}}
                @else
                    <a href="{{ route('login', ['redirect' => request()->fullUrl()]) }}" class="btn btn-primary w-100 py-3 fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Sign in to Send Inquiry
                    </a>
                @endauth
            </div>
        </div>

    </div>
</div>

<!-- Mobile Sticky CTA -->
<div class="d-lg-none position-fixed bottom-0 start-0 end-0 bg-white border-top p-3 shadow-lg" style="z-index: 1030;">
    <div class="d-flex justify-content-between align-items-center gap-3">
        <div>
            <p class="text-muted small mb-0">Price</p>
            <p class="fw-bold mb-0">₹{{ number_format($price, 2) }}</p>
        </div>
        @auth
            <button class="btn btn-primary flex-grow-1 py-2 fw-semibold">
                <i class="bi bi-send-fill me-1"></i> Send Inquiry
            </button>
        @else
            <a href="{{ route('login', ['redirect' => request()->fullUrl()]) }}" class="btn btn-primary flex-grow-1 py-2 fw-semibold">
                Sign in to Inquire
            </a>
        @endauth
    </div>
</div>
<div class="d-lg-none" style="height: 80px;"></div>

<!-- Gallery Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-dark border-0">
            <div class="modal-header border-0">
                <h5 class="text-white fw-bold">{{ $title }} — Gallery</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="galleryCarousel" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ $coverImage }}" class="d-block w-100 rounded-3 object-fit-contain" style="max-height: 70vh;" alt="">
                        </div>
                        @foreach ($thumbs as $img)
                            <div class="carousel-item">
                                <img src="{{ asset('storage/' . $img->file_path) }}" class="d-block w-100 rounded-3 object-fit-contain" style="max-height: 70vh;" alt="">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('shareBtn')?.addEventListener('click', async () => {
        if (navigator.share) {
            await navigator.share({
                title: @json($title),
                url: window.location.href
            });
        } else {
            await navigator.clipboard.writeText(window.location.href);
            alert('Link copied to clipboard!');
        }
    });

    document.getElementById('saveBtn')?.addEventListener('click', function () {
        this.classList.toggle('btn-outline-danger');
        this.classList.toggle('btn-danger');
        const icon = this.querySelector('i');
        icon.classList.toggle('bi-heart');
        icon.classList.toggle('bi-heart-fill');
        // TODO: hook up AJAX call to save/unsave property for the user
    });
</script>
@endpush

@endsection