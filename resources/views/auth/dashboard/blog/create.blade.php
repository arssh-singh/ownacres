@extends('layouts.app')

@push('styles')
<style>
    .editor-container {
    max-width: 680px;
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="container py-5 mt-5">

    <form id="blogForm">
        @csrf

        <div class="mx-auto editor-container">

            <input
                type="text"
                name="title"
                class="form-control border-0 shadow-none fs-1 fw-bold"
                placeholder="Title"
            >

            <input
                type="text"
                name="subtitle"
                class="form-control border-0 shadow-none fs-3 fw-medium mb-4"
                placeholder="Subtitle"
            >

            <div id="editorjs"></div>

            <input
                type="hidden"
                id="content"
                name="content"
            >

            <button
                type="submit"
                class="btn btn-primary mt-4"
            >
                Submit
            </button>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/paragraph@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/table@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/delimiter@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/image@latest"></script>

<script>
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
                config: {
                    levels: [1, 2, 3, 4],
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

            embed: {
                class: Embed
            },
            
            image: {
            class: ImageTool,
                config: {
                    endpoints: {
                        byFile: "{{ route('blog.image.upload') }}"
                    },
                    additionalRequestHeaders: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }
            }

        }

    });
    
    await editor.isReady;

    document.getElementById('blogForm').addEventListener('submit', async function (e) {

        e.preventDefault();

        try {

            const output = await editor.save();

            console.log(output);

            document.getElementById('content').value = JSON.stringify(output);

            // this.submit();

        } catch (error) {

            console.error(error);

        }

    });
});

</script>

@endpush