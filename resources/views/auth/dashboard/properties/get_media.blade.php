@extends('layouts.user')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.min.css">
<link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css">
<link rel="stylesheet" href="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.min.css">
@endpush
@section('content')


<div class="container-lg py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <form action="{{ route('properties.media.store', $property) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Main Image -->
                <div class="card mb-4">
                    <div class="card-body">
                        @error('mainImage')
                            <div class="text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                        <h5 class="card-title">
                            Main Image
                            <span class="text-danger">*</span>
                        </h5>

                        <p class="text-muted mb-3">
                            This image will appear as the cover photo.
                        </p>

                        <input
                            type="file"
                            name="mainImage"
                            id="mainImage"
                            accept="image/*"
                            required>
                        <div id="mainPreview" class="mt-3"></div>

                    </div>
                </div>

                <!-- Gallery -->
                <div class="card mb-4">
                    <div class="card-body">
                        @error('gallery')
                            <div class="text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                        <h5 class="card-title">
                            Gallery
                        </h5>

                        <p class="text-muted mb-3">
                            Upload up to 10 photos or videos. (optional).
                        </p>

                        <input
                            type="file"
                            class="form-control"
                            name="gallery[]"
                            id="gallery"
                            accept="image/*,video/*"
                            multiple>
                        <div id="galleryPreview" class="row g-3 mt-2"></div>

                    </div>
                </div>

                <button class="btn btn-primary px-4">
                    Save & Continue
                </button>

            </form>

        </div>
    </div>

</div>

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