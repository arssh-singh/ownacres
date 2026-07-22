@extends('layouts.user')
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.min.css">
<link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css">
<link rel="stylesheet" href="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    #map {
        height: 400px;
        border-radius: 12px;
    }
</style>
@endpush
@section('content')
<div class="p-lg-4 p-sm-0">
    @if ($errors->any())
        <div class="alert alert-danger">
            <pre>{{ print_r($errors->all(), true) }}</pre>
        </div>
    @endif
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

                @include('auth.dashboard.properties.edit.get_basics')
                @include('auth.dashboard.properties.edit.get_pricing')
                @include('auth.dashboard.properties.edit.get_location')

            </div>
            {{-- Right column --}}
            <div class="col-lg-5 d-flex flex-column gap-3">
                @include('auth.dashboard.properties.edit.get_media')
            </div>
        </div>
    </form>
</div>
@endsection