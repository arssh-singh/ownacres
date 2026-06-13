@extends('layouts.user')
@section('content')
<div class="container-fluid px-lg-5 px-3 mt-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
        <div>
            <p class="text-primary fw-semibold mb-1 text-uppercase small" style="letter-spacing: 1px;">Dashboard Overview</p>
            <h3 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name }} 👋</h3>
            <p class="text-muted mb-0">Here's a quick overview of your property listings.</p>
        </div>
        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fs-6">
            <i class="bi bi-houses-fill me-1"></i> {{ count($properties) }} {{ count($properties) === 1 ? 'Listing' : 'Listings' }}
        </span>
    </div>

    <!-- Property Cards -->
    <div class="row g-4">
        @forelse ($properties as $property)
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                <div class="position-relative">
                    <img src="{{ asset('storage/' . $property->image) }}"
                         class="w-100 object-fit-cover" style="height: 180px;" alt="{{ $property->title }}">
                    <span class="position-absolute top-0 end-0 m-2 badge bg-white text-primary fw-semibold px-3 py-2 rounded-pill shadow-sm">
                        ₹{{ number_format($property->price, 2) }}
                    </span>
                </div>

                <div class="card-body">
                    <h6 class="fw-bold mb-1 text-truncate">{{ $property->title }}</h6>
                    <p class="text-muted small mb-3">
                        <i class="bi bi-geo-alt text-primary"></i> {{ $property->location }}
                    </p>

                    <div class="d-flex justify-content-between text-muted small border-top pt-3 mb-3">
                        <span><i class="bi bi-box-seam-fill text-primary"></i> {{ $property->bedrooms }} Beds</span>
                        <span><i class="bi bi-droplet-fill text-primary"></i> {{ $property->bathrooms }} Baths</span>
                        <span><i class="bi bi-textarea text-primary"></i> {{ $property->area }} sqft</span>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('properties.edit', $property->id) }}"
                           class="btn btn-outline-primary btn-sm rounded-pill flex-grow-1">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="{{ route('properties.delete', $property->id) }}" method="POST"
                              class="flex-grow-1" onsubmit="return confirm('Are you sure you want to delete this property?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill w-100">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                <i class="bi bi-house fs-1 text-muted"></i>
                <p class="text-muted mt-2 mb-0">No properties found.</p>
            </div>
        </div>
        @endforelse
    </div>

</div>
@endsection