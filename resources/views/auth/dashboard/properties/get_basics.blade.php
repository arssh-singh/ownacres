@extends('layouts.user')
@section('content')
<div class="mt-5 mb-4">
    <p class="text-muted text-uppercase small fw-semibold mb-1">Step 2 of 4</p>
    <h1 class="fw-light">Let's start with the basics</h1>
    <p class="text-muted">Give your property a title and a short description buyers will see first.</p>
</div>

<form action="{{ route('properties.basics.store', compact('property')) }}" method="POST">
    @csrf

    <div class="mb-2">
        <label for="title" class="form-label text-muted small text-uppercase fw-semibold">Property Title</label>
        <input
            type="text"
            id="title"
            name="title"
            value="{{ old('title', $property->title) }}"
            placeholder="Sunny 3BHK Apartment in Model Town"
            class="form-control border-0 border-bottom px-2 rounded-2 px-0 fs-1 fw-light @error('title') is-invalid @enderror"
            style="font-size: 2REM !important"
            required
        >
        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-5">
        <label for="description" class="form-label text-muted small text-uppercase fw-semibold">Description</label>
        <textarea
            id="description"
            name="description"
            rows="6"
            placeholder="Describe what makes this property special — layout, amenities, nearby landmarks, condition, and anything a buyer would want to know."
            class="form-control border-0 p-2 border-bottom rounded-2 px-2 @error('description') is-invalid @enderror"
            style="font-size: 16px; resize: none"
            required
        >{{ old('description', $property->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="d-flex align-items-center justify-content-between">
        <span class="text-muted small">You can edit this later from your dashboard.</span>
        <button type="submit" class="btn btn-dark px-4 py-2">
            Save & Continue →
        </button>
    </div>

</form>
@endsection