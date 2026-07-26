@extends("layouts.user")
@push('styles')
    
        <style>
        .saved-property-item {
            transition: background-color .15s ease;
            border-radius: .5rem;
        }
        .saved-property-item:hover {
            background-color: #f8f9fa;
        }
        .min-w-0 { min-width: 0; }
        </style>
@endpush
@section("content")
<?php
$savedCount = $savedCount ?? 0;
$inquiriesCount = $inquiriesCount ?? 0;
$mylistedProperties = $mylistedProperties ?? 0;
$profileViews = $profileViews ?? 0;
?>
<div class="container-fluid px-lg-5 px-3 mt-5">

    <!-- Welcome Header -->
    @include('partials.alerts')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name }} 👋</h2>
            <p class="text-muted mb-0">Here's what's happening with your account today.</p>
        </div>
        <a href="{{ route('marketplace') }}" class="btn btn-primary px-4 py-2 fw-semibold">
            <i class="bi bi-search me-1"></i> Browse Properties
        </a>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">

        @php
            $stats = [
                [
                    'title' => 'Saved Properties',
                    'value' => $savedCount ?? 0,
                    'icon' => 'bi-heart-fill',
                    'bg' => 'bg-primary-subtle',
                    'color' => 'text-primary',
                ],
                [
                    'title' => 'Inquiries Sent',
                    'value' => $inquiriesCount ?? 0,
                    'icon' => 'bi-send-fill',
                    'bg' => 'bg-success-subtle',
                    'color' => 'text-success',
                ],
                [
                    'title' => 'My Listings',
                    'value' => $mylistedProperties ?? 0,
                    'icon' => 'bi-house-fill',
                    'bg' => 'bg-warning-subtle',
                    'color' => 'text-warning',
                ],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="{{ $stat['bg'] }} rounded-circle d-flex align-items-center justify-content-center"
                            style="width:48px; height:48px;">
                            <i class="bi {{ $stat['icon'] }} {{ $stat['color'] }} fs-5"></i>
                        </div>

                        <div>
                            <p class="text-muted small mb-0">{{ $stat['title'] }}</p>
                            <h4 class="fw-bold mb-0">{{ $stat['value'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <div class="row g-4">

        <!-- Saved Properties -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Saved Properties</h5>
                    <a href="{{ route('dashboard.savedProperties') }}" class="small text-decoration-none fw-medium">View All</a>
                </div>

                @forelse ($savedProperties ?? [] as $property)
                    <div class="d-flex align-items-center gap-3 py-3 px-2 saved-property-item {{ !$loop->last ? 'border-bottom' : '' }}">
                        <img src="{{ $property->coverImage?->file_path ? asset('storage/' . $property->coverImage->file_path) : asset('images/placeholder.jpg') }}"
                            class="rounded-3 object-fit-cover flex-shrink-0"
                            style="width:64px; height:64px;"
                            alt="{{ $property->basics?->title }}">

                        <div class="flex-grow-1 min-w-0">
                            <p class="fw-semibold mb-0 text-truncate">{{ $property->basics?->title }}</p>
                            <p class="text-muted small mb-0 text-truncate">
                                <i class="bi bi-geo-alt"></i> {{ $property->location->city }}
                            </p>
                        </div>

                        <div class="text-end flex-shrink-0">
                            <p class="fw-bold text-primary mb-0 text-nowrap">₹{{ number_format($property->price, 2) }}</p>
                            <a href="{{ route('properties.prop_details', $property->id) }}" class="small text-decoration-none">View</a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-heart fs-1 text-muted"></i>
                        <p class="text-muted mt-2 mb-0">You haven't saved any properties yet.</p>
                        <a href="{{ route('marketplace') }}" class="btn btn-sm btn-primary mt-3 rounded-pill px-4">Browse Properties</a>
                    </div>
                @endforelse
            </div>
        </div>


        <!-- Sidebar -->
        <div class="col-lg-4">

            <!-- Profile Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-center">
                <img src="{{ auth()->user()->profile_image_url }}"
                     class="rounded-circle mx-auto mb-3 object-fit-cover" style="width:80px; height:80px;" alt="">
                <h6 class="fw-bold mb-0">{{ auth()->user()->name }}</h6>
                <p class="text-muted small mb-3">{{ auth()->user()->email }}</p>
                <a href="{{ route('dashboard.profile') ?? '#' }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                    <i class="bi bi-pencil-square me-1"></i> Edit Profile
                </a>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h6 class="fw-bold mb-3">Quick Actions</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('properties.create') ?? '#' }}" class="btn btn-light text-start rounded-3 d-flex align-items-center gap-2">
                        <i class="bi bi-plus-circle text-primary"></i> Add New Listing
                    </a>
                    <a href="{{ route('dashboard.savedProperties') ?? '#' }}" class="btn btn-light text-start rounded-3 d-flex align-items-center gap-2">
                        <i class="bi bi-heart text-danger"></i> Saved Properties
                    </a>
                    <a href="{{ route('dashboard.messages') ?? '#' }}" class="btn btn-light text-start rounded-3 d-flex align-items-center gap-2">
                        <i class="bi bi-chat-dots text-success"></i> My Inquiries
                    </a>
                    <a href="{{ route('dashboard.profile') ?? '#' }}" class="btn btn-light text-start rounded-3 d-flex align-items-center gap-2">
                        <i class="bi bi-gear text-secondary"></i> Account Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection