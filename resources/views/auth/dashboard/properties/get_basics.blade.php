@extends('layouts.user')
@section('content')
<div class="mt-5">
    <h1 class="fw-light mb-5">Enter Basic Details</h1>
</div>
<form action="{{ route('properties.basics.store', compact('property')) }}" method="POST">
    @csrf

    <div class="mb-4">
        @error('title')
            <div class="text-danger small mt-2">
                {{ $message }}
            </div>
        @enderror
        <input
            type="text"
            name="title"
            value="{{ old('title', $property->title) }}"
            placeholder="Property title"
            class="form-control border-0 border-bottom rounded-0 px-0 fs-1 fw-light"
            style="font-size: clamp(2rem, 5vw, 3.5rem) !important"
            required
        >
    </div>

    <div class="mb-5">
        @error('description')
            <div class="text-danger small mt-2">
                {{ $message }}
            </div>
        @enderror
        <textarea
            name="description"
            rows="6"
            placeholder="Describe your property…"
            class="form-control border-0 border-bottom rounded-0 px-0"
            style="font-size: 16px; resize: none"
            required
        >{{ old('description', $property->description) }}</textarea>
    </div>

    <button type="submit" class="btn btn-dark px-4">
        Save & Continue →
    </button>

</form>
@endsection