@extends('layouts.app')
@section('content')
<div class="container-fluid px-lg-5 px-3 py-5">
    <div class="row g-3">

        <!-- Big Image -->
        <div class="col-lg-8">
            <img 
                src="{{ asset('storage/' . $property->image) }}"
                class="w-100 rounded-4 object-fit-cover"
                style="height: 620px;"
                alt=""
            >
        </div>

        <!-- Right Side Small Images -->
        <div class="col-lg-4">
            <div class="row g-3 h-100">

                <div class="col-12">
                    <img 
                        src="https://picsum.photos/600/400?random=2"
                        class="w-100 rounded-4 object-fit-cover"
                        style="height: 302px;"
                        alt=""
                    >
                </div>

                <div class="col-12">
                    <img 
                        src="https://picsum.photos/600/400?random=3"
                        class="w-100 rounded-4 object-fit-cover"
                        style="height: 302px;"
                        alt=""
                    >
                </div>

            </div>
        </div>

        <!-- Bottom Images -->
        <!-- <div class="col-md-6">
            <img 
                src="https://picsum.photos/800/500?random=4"
                class="w-100 rounded-4 object-fit-cover"
                style="height: 300px;"
                alt=""
            >
        </div>

        <div class="col-md-6">
            <img 
                src="https://picsum.photos/800/500?random=5"
                class="w-100 rounded-4 object-fit-cover"
                style="height: 300px;"
                alt=""
            >
        </div> -->

    </div>
</div>
<div class="container-fluid px-lg-5 py-1 mb-2">
    <div class="row g-4">
        <div class="col-lg-8">
            <h1 class="fw-bold display-1 m-0">{{ $property->title }}</h1>
            <p class="text-primary"><i class="bi bi-geo-alt"></i> {{ $property->location }}</p>

        </div>
        <div class="col-lg-4">
            <h1 class="fw-bold my-auto display-1 text-muted">₹{{ number_format($property->price, 2) }}</h1>
            <div class="d-flex gap-4 mt-4 text-primary">
                <h4><i class="bi bi-textarea"></i> {{ $property->area }} sqft</h4>
                <h4><i class="bi bi-box-seam-fill"></i> {{ $property->bedrooms }} Beds</h4>
                <h4><i class="bi bi-person-standing"></i> {{ $property->bathrooms }} Baths</h4>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid px-lg-5 py-1 bg-light">
    <!-- description -->
    <div class="row g-4 mt-2">
        <div class="col-lg-12 mt-5">
            <h2 class="fw-bold">Property Details</h2>
        </div>
        <div class="col-lg-12">
            <p class="text-muted">{{ $property->description }}</p>
            <!-- details with icons -->

        </div>
        <!-- button to left -->
        <div class="col-lg-12">
            @auth
                <button class="btn btn-primary w-100 py-3">Send Inquiry</button>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary w-100 py-3">Sign in to Send Inquiry</a>
            @endauth
        </div>
    </div>
</div>
@endsection