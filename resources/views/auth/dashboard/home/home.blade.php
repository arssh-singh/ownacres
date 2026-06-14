@extends("layouts.user")
@section("content")
<?php
$savedCount = $savedCount ?? 0;
$inquiriesCount = $inquiriesCount ?? 0;
$listingsCount = $listingsCount ?? 0;
$profileViews = $profileViews ?? 0;
?>
<div class="container-fluid px-lg-5 px-3 mt-5">

    <!-- Welcome Header -->
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
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                        <i class="bi bi-heart-fill text-primary fs-5"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Saved Properties</p>
                        <h4 class="fw-bold mb-0">{{ $savedCount ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                        <i class="bi bi-send-fill text-success fs-5"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Inquiries Sent</p>
                        <h4 class="fw-bold mb-0">{{ $inquiriesCount ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                        <i class="bi bi-house-fill text-warning fs-5"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">My Listings</p>
                        <h4 class="fw-bold mb-0">{{ $listingsCount ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-info-subtle rounded-circle d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                        <i class="bi bi-eye-fill text-info fs-5"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Profile Views</p>
                        <h4 class="fw-bold mb-0">{{ $profileViews ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- Saved Properties -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Saved Properties</h5>
                    <a href="{{ route('dashboard.savedProperties') ?? '#' }}" class="small text-decoration-none">View All</a>
                </div>

                @forelse ($savedProperties ?? [] as $property)
                    <div class="d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <img src="{{ asset('storage/' . $property->image) }}" class="rounded-3 object-fit-cover" style="width:70px; height:70px;" alt="">
                        <div class="flex-grow-1">
                            <p class="fw-semibold mb-0">{{ $property->title }}</p>
                            <p class="text-muted small mb-0"><i class="bi bi-geo-alt"></i> {{ $property->location }}</p>
                        </div>
                        <div class="text-end">
                            <p class="fw-bold text-primary mb-0">₹{{ number_format($property->price, 2) }}</p>
                            <a href="{{ route('properties.prop_details', $property->id) }}" class="small text-decoration-none">View</a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-heart fs-1 text-muted"></i>
                        <p class="text-muted mt-2 mb-0">You haven't saved any properties yet.</p>
                        <a href="{{ route('marketplace') }}" class="btn btn-sm btn-primary mt-3">Browse Properties</a>
                    </div>
                @endforelse
            </div>

            <!-- Recent Inquiries -->
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Recent Inquiries</h5>
                    <a href="{{ route('dashboard') ?? '#' }}" class="small text-decoration-none">View All</a>
                </div>

                @forelse ($recentInquiries ?? [] as $inquiry)
                    <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div>
                            <p class="fw-semibold mb-0">{{ $inquiry->property->title ?? 'Property' }}</p>
                            <p class="text-muted small mb-0">{{ $inquiry->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="badge rounded-pill bg-{{ $inquiry->status === 'replied' ? 'success' : 'secondary' }}-subtle text-{{ $inquiry->status === 'replied' ? 'success' : 'secondary' }} px-3 py-2">
                            {{ ucfirst($inquiry->status ?? 'pending') }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-chat-dots fs-1 text-muted"></i>
                        <p class="text-muted mt-2 mb-0">No inquiries sent yet.</p>
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
                <a href="{{ route('home') ?? '#' }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                    <i class="bi bi-pencil-square me-1"></i> Edit Profile
                </a>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h6 class="fw-bold mb-3">Quick Actions</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('create-prop') ?? '#' }}" class="btn btn-light text-start rounded-3 d-flex align-items-center gap-2">
                        <i class="bi bi-plus-circle text-primary"></i> Add New Listing
                    </a>
                    <a href="{{ route('dashboard') ?? '#' }}" class="btn btn-light text-start rounded-3 d-flex align-items-center gap-2">
                        <i class="bi bi-heart text-danger"></i> Saved Properties
                    </a>
                    <a href="{{ route('dashboard') ?? '#' }}" class="btn btn-light text-start rounded-3 d-flex align-items-center gap-2">
                        <i class="bi bi-chat-dots text-success"></i> My Inquiries
                    </a>
                    <a href="{{ route('dashboard') ?? '#' }}" class="btn btn-light text-start rounded-3 d-flex align-items-center gap-2">
                        <i class="bi bi-gear text-secondary"></i> Account Settings
                    </a>
                </div>
            </div>

            <!-- My Listings -->
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">My Listings</h6>
                    <a href="{{ route('dashboard') ?? '#' }}" class="small text-decoration-none">+ Add</a>
                </div>

                @forelse ($myListings ?? [] as $listing)
                    <div class="d-flex align-items-center gap-2 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <img src="{{ asset('storage/' . $listing->image) }}" class="rounded-3 object-fit-cover" style="width:45px; height:45px;" alt="">
                        <div class="flex-grow-1">
                            <p class="small fw-semibold mb-0 text-truncate" style="max-width: 140px;">{{ $listing->title }}</p>
                            <p class="text-muted small mb-0">₹{{ number_format($listing->price) }}</p>
                        </div>
                        <span class="badge bg-{{ $listing->status === 'active' ? 'success' : 'secondary' }}-subtle text-{{ $listing->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($listing->status ?? 'active') }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted small text-center py-3 mb-0">No listings yet.</p>
                @endforelse
            </div>

        </div>
    </div>

</div>
@endsection