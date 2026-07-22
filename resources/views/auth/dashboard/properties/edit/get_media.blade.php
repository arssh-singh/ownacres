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
    <button type="submit" class="btn btn-dark" id="savebtn">Save changes</button>
</div>
<input type="hidden" name="changed[cover_image]" value="0">
<input type="hidden" name="changed[media]" value="0">
@push('scripts')
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.min.js"></script>

<script>
    FilePond.registerPlugin(FilePondPluginImagePreview);
    FilePond.registerPlugin(FilePondPluginFileValidateType);
    const savebtn = document.querySelector('#savebtn');
    // selecting hidden with name
    const coverImageInput = document.querySelector('input[name="changed[cover_image]"]');
    const mediaInput = document.querySelector('input[name="changed[media]"]');
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
coverPond.on('addfilestart', (file) => {
    if (file.origin === FilePond.FileOrigin.LOCAL) {
        return; // Existing image, ignore
    }

    savebtn.disabled = true;
});
coverPond.on('processfile', (error, file) => {
    if (error) {
        console.error('Error processing file:', error);
        return;
    }

    savebtn.disabled = false;
    coverImageInput.value = 1; // Set the serverId to the input value
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
    meidaPond.on('addfilestart', (file) => {
        if (file.origin === FilePond.FileOrigin.LOCAL) {
            return; // Existing image, ignore
        }

        savebtn.disabled = true;
    });
    const mediaEvents = ['processfile', 'removefile', 'addfile', 'reorderfiles'];
    mediaEvents.forEach(event => {
        meidaPond.on(event, (...args) => {
            mediaInput.value = 1; // Set the serverId to the input value
        });
    });
    meidaPond.on('processfile', (error, file) => {
        if (error) {
            console.error('Error processing file:', error);
            return;
        }

        savebtn.disabled = false;
    });
</script>
@endpush