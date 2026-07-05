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
    <div class="row">
        @foreach ($properties as $property)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <x-property-card 
                    :property="$property"
                    image="{{ $property->coverImageUrl }}"
                    title="{{ $property->display_title }}"
                    description="{{ $property->display_description }}"
                    href="{{ route('properties.prop_details', $property->id) }}" 
                    status="{{ $property->status }}"
                    edit-href="{{ route('properties.edit', $property->id) }}"
                    del-href="{{ route('properties.delete', $property->id) }}"
                />
            </div>
            
        @endforeach
    </div>  

</div>
@endsection