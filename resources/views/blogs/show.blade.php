@extends('layouts.app')
{{-- =========================
    Basic SEO
========================= --}}

@section(
    'title',
    $blog->meta_title ?: $blog->title
)

@section(
    'description',
    $blog->meta_description ?: $blog->subtitle
)

@section(
    'robots',
    'index,follow'
)
{{-- =========================
    Canonical
========================= --}}

@section(
    'canonical',
    url()->current()
)

{{-- =========================
    Open Graph
========================= --}}

@section('og_type', 'article')

@section(
    'og_title',
    $blog->meta_title ?: $blog->title
)

@section(
    'og_description',
    $blog->meta_description ?: $blog->subtitle
)

@section(
    'og_url',
    url()->current()
)
{{-- =========================
    Twitter
========================= --}}

@section(
    'twitter_title',
    $blog->meta_title ?: $blog->title
)

@section(
    'twitter_description',
    $blog->meta_description ?: $blog->subtitle
)

@section(
    'twitter_image',
    $blog->image_url
        ? asset('storage/' . $blog->image_url)
        : asset('storage/images/seo/og_default.png')
)


{{-- =========================
    Page Content
========================= --}}
@section(
    'og_image',
    $blog->image_url
        ? asset('storage/' . $blog->image_url)
        : asset('storage/images/seo/og_default.png')
)
@php
    $seoTitle = $blog->meta_title ?: $blog->title;

    $seoDescription = $blog->meta_description ?: $blog->subtitle;

    $seoImage = $blog->image_url
        ? asset('storage/' . $blog->image_url)
        : asset('storage/images/seo/og_default.png');

    $canonical = url()->current();

    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',

        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => $canonical,
        ],

        'headline' => $seoTitle,
        'description' => $seoDescription,

        'image' => [
            $seoImage,
        ],

        'datePublished' => $blog->created_at?->toIso8601String(),
        'dateModified' => $blog->updated_at?->toIso8601String(),

        'author' => [
            '@type' => 'Organization',
            'name' => 'OwnAcres',
            'url' => url('/'),
        ],

        'publisher' => [
            '@type' => 'Organization',
            'name' => 'OwnAcres',
            'url' => url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('storage/images/seo/og_default.png'),
            ],
        ],
    ];
@endphp

@push('structured-data')
<script type="application/ld+json">
{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush
@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500&display=swap" rel="stylesheet">
<style>
.blog-paragraph {
    font-family: "Lora", Georgia, serif;
    font-size: 1.05rem;
    line-height: 1.85;
    letter-spacing: 0.005em;
}
</style>    
@endpush
@section('content')
<div class="container pt-5 mt-5">
    <div class="col-12 col-md-8 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">Home</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('blogs') }}">Blog</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    {{ $blog->title }}
                </li>
            </ol>
        </nav>
        <article>
            <header class="mb-4">
                <h1 class="mb-1">{{ $blog?->title }}</h1>
                @if($blog?->subtitle)
                    <h6 class="text-muted fw-normal fst-italic">{{ $blog->subtitle }}</h6>
                @endif
            </header>

            @if($blog?->image_url)
                <img
                    class="img-fluid rounded mb-4"
                    src="{{ asset('storage/'.$blog->image_url) }}"
                    alt="{{ $blog->title }}"
                />
            @endif

            <div id="blog-content"></div>
        </article>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {

    const data = @json(json_decode($blog->content, true));
    const container = document.getElementById("blog-content");

    const renderers = {

        header(block) {
            // clamp heading level between 2-6 for sane blog hierarchy, add responsive fluid type
            const level = Math.min(Math.max(block.data.level, 2), 6);
            return `
                <h${level} class="fw-bold mb-3 mb-md-4 lh-sm">
                    ${block.data.text}
                </h${level}>
            `;
        },
        paragraph(block) {
            return `
                <p class="mb-3 mb-md-4 fs-6 fs-md-5 lh-lg text-body blog-paragraph">
                    ${block.data.text}
                </p>
            `;
        },

        list(block) {
            const tag = block.data.style === "ordered" ? "ol" : "ul";

            const items = block.data.items
                .map(item => `<li class="mb-2">${item.content}</li>`)
                .join("");

            return `
                <${tag} class="mb-3 mb-md-4 ps-4 fs-6 fs-md-5 lh-lg">
                    ${items}
                </${tag}>
            `;
        },

        table(block) {
            if (!block.data?.content?.length) return "";

            const [headRow, ...bodyRows] = block.data.content;
            const withHeadings = block.data.withHeadings;

            const theadHtml = withHeadings
                ? `
                    <thead class="table-light">
                        <tr>
                            ${headRow.map(cell => `<th scope="col">${cell}</th>`).join("")}
                        </tr>
                    </thead>
                `
                : "";

            const bodySource = withHeadings ? bodyRows : block.data.content;

            const tbodyHtml = bodySource
                .map(row => `
                    <tr>
                        ${row.map(cell => `<td>${cell}</td>`).join("")}
                    </tr>
                `)
                .join("");

            return `
                <div class="table-responsive my-4 rounded border">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0 small small-md-normal">
                        ${theadHtml}
                        <tbody>
                            ${tbodyHtml}
                        </tbody>
                    </table>
                </div>
            `;
        },

        quote(block) {
            return `
                <figure class="border-start border-4 border-primary ps-3 ps-md-4 py-1 my-4 my-md-5 bg-light bg-opacity-50 rounded-end">
                    <blockquote class="blockquote mb-2 fs-6 fs-md-5 fst-italic">
                        <p class="mb-0">${block.data.text}</p>
                    </blockquote>
                    ${
                        block.data.caption
                            ? `<figcaption class="blockquote-footer mt-2 mb-0">
                                ${block.data.caption}
                            </figcaption>`
                            : ""
                    }
                </figure>
            `;
        },

        delimiter() {
            return `
                <div class="text-center my-4 my-md-5">
                    <span class="fs-4 text-muted">⁂</span>
                </div>
            `;
        },
        image(block) {
            const data = block.data || {};
            const file = data.file || {};
            const url = file.url;

            if (!url) {
                return "";
            }

            const caption = data.caption
                ? `
                    <figcaption class="figure-caption mt-2 text-center">
                        ${data.caption}
                    </figcaption>
                `
                : "";

            const imageClasses = [
                "img-fluid",
                "rounded",
                data.withBorder ? "border" : "",
                data.withBackground ? "p-3 bg-light" : "",
            ]
                .filter(Boolean)
                .join(" ");

            const imageStyle = data.stretched
                ? "width: 100%;"
                : "";

            return `
                <figure class="my-4 my-md-5 ${data.stretched ? "w-100" : ""}">
                    <img
                        src="${url}"
                        alt="${data.caption || ""}"
                        class="${imageClasses}"
                        style="${imageStyle}"
                        loading="lazy"
                    >
                    ${caption}
                </figure>
            `;
        },

    };

    let html = "";

    data.blocks.forEach(block => {

        if (renderers[block.type]) {
            html += renderers[block.type](block);
        } else {
            console.warn("Unsupported block:", block.type);
        }

    });

    container.innerHTML = html;

});
</script>
@endpush