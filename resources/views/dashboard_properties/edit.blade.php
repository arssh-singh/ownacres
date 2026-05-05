@extends('layouts.user')
@section('content')
<div class="p-lg-4 p-sm-0">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <p class="text-muted mb-0" style="font-size:11px; letter-spacing:.06em">PROPERTIES</p>
            <h2 class="fw-semibold mb-0">Edit property</h2>
        </div>
        <span class="badge bg-success-subtle text-success">Active listing</span>
    </div>

    <form action="{{route('properties.update', $property->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3 align-items-start">

            {{-- Left column --}}
            <div class="col-lg-7 d-flex flex-column gap-3">

                <div class="card border rounded-3 p-3">
                    <p class="text-muted mb-3" style="font-size:11px; letter-spacing:.06em">BASIC INFO</p>
                    <div class="mb-3">
                        <label class="form-label small">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $property->title }}">
                    </div>
                    <div>
                        <label class="form-label small">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ $property->description }}</textarea>
                    </div>
                </div>

                <div class="card border rounded-3 p-3">
                    <p class="text-muted mb-3" style="font-size:11px; letter-spacing:.06em">DETAILS</p>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small">Bedrooms</label>
                            <input type="number" name="bedrooms" class="form-control" value="{{ $property->bedrooms }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small">Bathrooms</label>
                            <input type="number" name="bathrooms" class="form-control" value="{{ $property->bathrooms }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small">Area (sqft)</label>
                            <input type="number" name="area" class="form-control" value="{{ $property->area }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small">Location</label>
                            <input type="text" name="location" class="form-control" value="{{ $property->location }}">
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right column --}}
            <div class="col-lg-5 d-flex flex-column gap-3">

                <div class="card border rounded-3 p-3">
                    <p class="text-muted mb-3" style="font-size:11px; letter-spacing:.06em">PRICING</p>
                    <label class="form-label small">Price (USD)</label>
                    <input type="text" name="price" class="form-control" value="{{ $property->price }}">
                </div>

                <div class="card border rounded-3 p-3">
                    <p class="text-muted mb-3" style="font-size:11px; letter-spacing:.06em">PROPERTY IMAGE</p>
                    <img src="{{ asset('storage/' . $property->image) }}"
                         class="rounded-2 w-100 mb-3" style="height:180px; object-fit:cover;">
                    <label class="form-label small">Replace image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('dashboard.properties') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-dark">Save changes</button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection