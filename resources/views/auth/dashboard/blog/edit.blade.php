@extends('layouts.app')

@push('styles')
<style>
    .editor-container {
    max-width: 680px;
}
</style>
<!-- FilePond CSS -->
<link
    href="https://unpkg.com/filepond/dist/filepond.min.css"
    rel="stylesheet"
/>

<!-- Image Preview Plugin CSS -->
<link
    href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
    rel="stylesheet"
/>
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css"
/>

<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
@php
    $title = $blog->title ?? '';
    $subtitle = $blog->subtitle ?? '';
    $content = $blog->content ?: '{"blocks":[]}';
    $meta_description = $blog->meta_description ?? '';
    $tags = $blog->tags ?? '';
@endphp
<div class="container py-5 mt-5">
    @include('partials.alerts');
    @if(session('success'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="saveToast" class="toast text-bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    ✅ {{ session('success') }}
                </div>
                <button
                    type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"
                ></button>
            </div>
        </div>
    </div>
    @endif
    <form id="blogForm" method="POST" action="{{ route('blog.update', $blog->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mx-auto editor-container">

            <input
                type="text"
                name="title"
                class="form-control border-0 shadow-none fs-1 fw-bold"
                placeholder="Title"
                value="{{ old('title', $title) }}"
            >

            <input
                type="text"
                name="subtitle"
                class="form-control border-0 shadow-none fs-3 fw-medium mb-4"
                placeholder="Subtitle"
                value="{{ old('subtitle', $subtitle) }}"
            >

            <div id="editorjs"></div>

            <input
                type="hidden"
                id="content"
                name="content"
            >

            <input
                type="text"
                name="meta_description"
                class="form-control border-0 shadow-none fs-6 fw-medium mb-4"
                placeholder="Meta Description"
                value="{{ old('meta_description', $meta_description) }}"
            >
            <input
                type="text"
                name="tags"
                class="form-control border-0 shadow-none fs-6 fw-medium mb-4"
                placeholder="Tags"
                value="{{ old('tags', $tags) }}"
            >
            
            <input
                type="file"
                class="filepond"
                name="image"
                accept="image/*"
            />
            {{-- showing image if previously added --}}
            <img class="img-fluid" src="{{ asset('storage/' . $blog?->image_url) }}"/>
            <button
                type="submit"
                class="btn btn-primary mt-4"
            >
                Submit
            </button>

        </div>

    </form>

</div>

<div class="modal fade" id="cropModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Crop Image</h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body p-0">
                <div
                    style="
                        width:100%;
                        height:70vh;
                        overflow:hidden;
                        display:flex;
                        justify-content:center;
                        align-items:center;
                    "
                >
                    <img
                        id="cropImage"
                        style="
                            display:block;
                            max-width:100%;
                        "
                    >
                </div>
            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="cropButton">
                    Crop
                </button>

            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- FilePond -->
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<!-- Plugins -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>

<!-- Cropper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
@endpush

@push('scripts')

<script>
FilePond.registerPlugin(FilePondPluginImagePreview);

const pond = FilePond.create(document.querySelector(".filepond"), {
    allowProcess: false,
    storeAsFile: true,
    allowPaste: false
});

const cropModalElement = document.getElementById("cropModal");
const cropModal = new bootstrap.Modal(cropModalElement);

const cropImage = document.getElementById("cropImage");

let cropper = null;
let currentFileItem = null;

let isAddingCroppedFile = false;
// User selects an image
pond.on("addfile", (error, fileItem) => {

    if (error) return;

    // Don't reopen cropper for the already-cropped image
    if (isAddingCroppedFile) {
        isAddingCroppedFile = false;
        return;
    }

    currentFileItem = fileItem;

    cropImage.src = URL.createObjectURL(fileItem.file);

    // Remove it immediately so FilePond becomes empty
    pond.removeFile(fileItem.id);

    cropModal.show();
});

// Initialize Cropper
cropModalElement.addEventListener("shown.bs.modal", () => {

    if (cropper) {
        cropper.destroy();
    }

    cropper = new Cropper(cropImage, {
        aspectRatio: 16 / 9,
        viewMode: 2,
        responsive: true,
        autoCropArea: 1,
        dragMode: "move",
        movable: true,
        zoomable: true,
        rotatable: false,
        scalable: false,
        cropBoxMovable: false,
        cropBoxResizable: false,
        guides: false,
        center: true,
        highlight: false,
        background: false,
    });

});

// Cleanup
cropModalElement.addEventListener("hidden.bs.modal", () => {

    if (cropper) {
        cropper.destroy();
        cropper = null;
    }

});
document.getElementById("cropButton").addEventListener("click", () => {

    if (!cropper || !currentFileItem) return;

    const canvas = cropper.getCroppedCanvas({
        width: 1920,
        height: 1080,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: "high",
    });

    canvas.toBlob((blob) => {

        const croppedFile = new File(
            [blob],
            currentFileItem.file.name,
            {
                type: currentFileItem.file.type,
                lastModified: Date.now()
            }
        );

        // Remove original image
        isAddingCroppedFile = true;

        // Add cropped image
        pond.addFile(croppedFile);

        cropModal.hide();

    }, currentFileItem.file.type);

});
cropModalElement.addEventListener("hidden.bs.modal", () => {

    if (cropper) {
        cropper.destroy();
        cropper = null;
    }

    currentFileItem = null;

});
</script>
@endpush

@push('scripts')

<!-- Editor -->
<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/paragraph@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/table@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/delimiter@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/image@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/code@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/warning@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/marker@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/inline-code@latest"></script>

<script>
const blogId = @json($blog->id);
const csrfToken = @json(csrf_token());
document.addEventListener('DOMContentLoaded', async function () {
    const editor = new EditorJS({

        holder: "editorjs",

        autofocus: true,

        placeholder: "Start writing your blog...",

        inlineToolbar: true,

        tools: {

            header: {
                class: Header,
                inlineToolbar: true,
                shortcut: "CMD+SHIFT+1",
                config: {
                    levels: [1, 2, 3, 4, 5, 6],
                    defaultLevel: 2
                }
            },
            paragraph: {
                class: Paragraph,
                inlineToolbar: true
            },
            list: {
                class: EditorjsList,
                inlineToolbar: true
            },
            table: {
                class: Table
            },

            quote: {
                class: Quote,
                inlineToolbar: true
            },

            delimiter: {
                class: Delimiter
            },
            image: {
                class: ImageTool,

                config: {
                    endpoints: {
                        byFile: @json(route('blog.content-image', $blog->id))
                    },

                    additionalRequestHeaders: {
                        "X-CSRF-TOKEN": @json(csrf_token())
                    }
                }
            }
        },
        data: {!! old('content', $content) !!}

    });
    
    document.getElementById('blogForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        try {
            await editor.isReady;

            const output = await editor.save();

            document.getElementById('content').value = JSON.stringify(output);

            this.submit();
        } catch (error) {
            console.error('Editor.js error:', error);
        }
    });

    const toast = new bootstrap.Toast(document.getElementById('saveToast'), {
        delay: 1000
    });

    toast.show();
});
</script>

@endpush