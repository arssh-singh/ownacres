@extends('layouts.user')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.min.css">
<link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css">
<link rel="stylesheet" href="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.min.css">
@endpush
@section('content')

<div class="mt-5 mb-4">
    <p class="text-muted text-uppercase small fw-semibold mb-1">Step 4 of 4</p>
    <h1 class="fw-light">Add photos & videos</h1>
    <p class="text-muted">A great cover photo and a few gallery shots help your listing stand out.</p>
</div>

<form action="{{ route('properties.media.store', $property) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Main Image -->
    <div class="mb-5">
        <label class="form-label text-muted small text-uppercase fw-semibold">
            Main Image <span class="text-danger">*</span>
        </label>
        <p class="text-muted small mb-3">
            This will appear as the cover photo for your listing.
        </p>

        <div class="border rounded-3 bg-light bg-opacity-50 p-3">
            <input
                type="file"
                name="mainImage"
                id="mainImage"
                accept="image/*"
                required>
            <div id="mainPreview" class="mt-3"></div>
        </div>

        @error('mainImage')
            <div class="text-danger small mt-2">
                {{ $message }}
            </div>
        @enderror
    </div>

    <!-- Gallery -->
    <div class="mb-5">
        <label class="form-label text-muted small text-uppercase fw-semibold">Gallery</label>
        <p class="text-muted small mb-3">
            Upload up to 10 additional photos or videos (optional).
        </p>

        <div class="border rounded-3 bg-light bg-opacity-50 p-3">
            <input
                type="file"
                name="gallery[]"
                id="gallery"
                accept="image/*,video/*"
                multiple>
            <div id="galleryPreview" class="row g-3 mt-2"></div>
        </div>

        @error('gallery')
            <div class="text-danger small mt-2">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="d-flex align-items-center justify-content-between">
        <span class="text-muted small">You can add or change photos later from your dashboard.</span>
        <button type="submit" class="btn btn-dark px-4 py-2">
            Save & Continue →
        </button>
    </div>

</form>

@endsection

@push('scripts')
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>
<script>
FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginMediaPreview,
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize
);
FilePond.create(document.querySelector('#mainImage'), {
    allowMultiple: false,
    acceptedFileTypes: ['image/*'],
    storeAsFile: true,
    credits: false
});

FilePond.create(document.querySelector('#gallery'), {
    allowMultiple: true,
    acceptedFileTypes: ['image/*', 'video/*'],
    storeAsFile: true,
    maxFiles: 10,
    maxFileSize: '100MB',
    credits: false
});
</script>
{{-- disable submit btn --}}
<script>
document.querySelector('form').addEventListener('submit', function () {
    const button = this.querySelector('button[type="submit"]');

    button.disabled = true;
    button.innerHTML = 'Saving...';
});
</script>
@endpush