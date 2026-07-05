@extends('layouts.user')
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.min.css">
<link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css">
<link rel="stylesheet" href="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.min.css">
@endpush
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
                        <input type="text" name="title" id="title" class="form-control" value="{{ $property->display_title }}">
                    </div>
                    <div>
                        <label class="form-label small">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4">{{ $property->display_description }}</textarea>
                    </div>
                </div>

                <div class="card border rounded-3 p-3">
                    <p class="text-muted mb-3" style="font-size:11px; letter-spacing:.06em">Pricing</p>
                    <div class="mb-3">
                        <label class="form-label small">Rent/Sale</label>
                        <select
                            name="listing_type"
                            class="form-select border-0 border-bottom rounded-0 px-0"
                        >
                            <option value="">Select Listing Type</option>
                            <option value="sale" @selected($property->pricing?->listing_type === 'sale')>
                                Sale
                            </option>
                            <option value="rent" @selected($property->pricing?->listing_type === 'rent')>
                                Rent
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label small">Pricing</label>
                        <input
                            type="number"
                            name="price"
                            value="{{ $property->price }}"
                            placeholder="Enter Price"
                            class="form-control border-0 border-bottom rounded-0 px-0 fs-2 fw-light"
                            min="0"
                            required
                        >
                    </div>
                </div>

            </div>
            {{-- Right column --}}
            <div class="col-lg-5 d-flex flex-column gap-3">
                <div class="card border rounded-3 p-3">
                    <input
                        type="file"
                        id="coverImage"
                        name="cover_image" required>
                </div>

                <div class="card border rounded-3 p-3">
                    <p class="text-muted mb-3" style="font-size:11px; letter-spacing:.06em">PROPERTY MEDIA</p>
                    <label class="form-label small">Replace image</label>
                    <input
                            type="file"
                            id="propertyMedia"
                            name="media[]"
                            multiple
                        >
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('dashboard.properties') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-dark">Save changes</button>
                </div>

            </div>
        </div>
        {{-- adding hidden inputs --}}
        <input type="hidden" name="changed[basics]" value="0">
        <input type="hidden" name="changed[pricing]" value="0">
        <input type="hidden" name="changed[cover_image]" value="1">
        <input type="hidden" name="changed[media]" value="1">

    </form>
</div>
@endsection
@push('scripts')
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.min.js"></script>

<script>
    FilePond.registerPlugin(FilePondPluginImagePreview);
    FilePond.registerPlugin(FilePondPluginFileValidateType);
</script>
<script>
const coverImageElement = document.querySelector('#coverImage');
const coverPond = FilePond.create(coverImageElement, {
    acceptedFileTypes: ['image/*'],
    server: {
        load: (source, load, error, progress, abort, headers) => {
            const myRequest = new Request(source);
            fetch(myRequest).then((res) => {
                return res.blob();
            }).then(load);
        },
        process: '{{ route('property.temp.upload') }}',
        revert: '{{ route('property.temp.delete') }}',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    },
    files: [
        {
            source: '{{ Storage::disk("public")->url($property->coverImage->file_path) }}',
            options: {
                type: 'local',
            },
        }
    ],
});
</script>
<script>
    const mediaElement = document.querySelector('#propertyMedia');
    const storageUrl = "{{ Storage::disk('public')->url('') }}";

    const meidaPond = FilePond.create(mediaElement, {
        acceptedFileTypes: ['image/*'],
        allowMultiple: true,
        allowReorder: true,
        server: {
            load: (source, load, error, progress, abort) => {
                fetch(storageUrl + source)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to load file.');
                        }

                        return response.blob();
                    })
                    .then(load)
                    .catch(error);
            },
            process: '{{ route('property.temp.upload') }}',
            revert: '{{ route('property.temp.delete') }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        files: [
            @foreach($property->media as $media)
            {
                source: '{{$media->file_path}}',
                options: {
                    type: 'local'
                }
            },
            @endforeach
        ]
    })
</script>

<script>
    // detect changes in title and description and set the hidden input value to 1
    const title = document.querySelector('#title');
    const description = document.querySelector('#description');
    const basicsInput = document.querySelector('input[name="changed[basics]"]');
    title.addEventListener('input', () => {
        basicsInput.value = 1;
        console.log('Title changed, setting changed[basics] to 1');
    });
    description.addEventListener('input', () => {
        basicsInput.value = 1;
        console.log('Description changed, setting changed[basics] to 1');
    });
</script>
<script>
    // detect changes in price and listing type and set the hidden input value to 1
    const price = document.querySelector('input[name="price"]');
    const listingType = document.querySelector('select[name="listing_type"]');
    const pricingInput = document.querySelector('input[name="changed[pricing]"]');
    price.addEventListener('input', () => {
        pricingInput.value = 1;
        console.log('Price changed, setting changed[pricing] to 1');
    });
    listingType.addEventListener('change', () => {
        pricingInput.value = 1;
        console.log('Listing type changed, setting changed[pricing] to 1');
    });
</script>
@endpush