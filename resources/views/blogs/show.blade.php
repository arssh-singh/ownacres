@extends('layouts.app')
{{-- ========================= --}}
{{-- SEO --}}
{{-- ========================= --}}

@php
    use Illuminate\Support\Str;

    $seoTitle = $blog->seo_title ?: $blog->title . ' | OwnAcres';

    $seoDescription = $blog->meta_description
        ?: Str::limit(strip_tags($blog->subtitle ?: $blog->content), 155);

    $seoImage = asset('storage/' . $blog->image_url);

    $seoCanonical = route('blogs.show', $blog->id);
@endphp

@section('title', $seoTitle)

@section('description', $seoDescription)

@section('canonical', $seoCanonical)

@section('og_type', 'article')

@section('og_title', $seoTitle)

@section('og_description', $seoDescription)

@section('og_image', $seoImage)

@section('twitter_image', $seoImage)

{{-- ========================= --}}
{{-- Content --}}
{{-- ========================= --}}

@section('content')

{{-- JSON-LD Article Schema --}}
<script type="application/ld+json">
{
    "@@context":"https://schema.org",
    "@@type":"Article",
    "headline":"{{ e($blog->title) }}",
    "description":"{{ e($blog->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($blog->subtitle ?: $blog->content),155)) }}",
    "keywords":"{{ $blog->tags }}",
    "articleSection":"Blog",
    "url":"{{ route('blogs.show',$blog->id) }}",
    "image":"{{ asset('storage/'.$blog->image_url) }}",
    "datePublished":"{{ \Carbon\Carbon::parse($blog->date_published)->toIso8601String() }}",
    "dateModified":"{{ $blog->updated_at->toIso8601String() }}",
    "author":{
        "@@type":"Person",
        "name":"{{ $blog->author->name ?? 'OwnAcres' }}"
    },
    "publisher":{
        "@type":"Organization",
        "name":"OwnAcres",
        "logo":{
            "@@type":"ImageObject",
            "url":"{{ asset('images/logo.png') }}"
        }
    },
    "mainEntityOfPage":{
        "@@type":"WebPage",
        "@@id":"{{ route('blogs.show',$blog->id) }}"
    }
}
</script>

<main class="container py-5 mt-5">

    <article itemscope itemtype="https://schema.org/Article">
        <div class="row justify-content-center">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">

                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('blogs') }}">Blog</a>
                    </li>

                    <li class="breadcrumb-item active">
                        {{ $blog->title }}
                    </li>

                </ol>
            </nav>
            <div class="col-lg-9">
                {{-- Title --}}
                <h1 class="display-4 fw-bold mb-3" itemprop="headline">
                    {{ $blog->title }}
                </h1>

                {{-- Subtitle --}}
                @if($blog->subtitle)
                    <p
                            class="lead text-secondary mb-4"
                            itemprop="description"
                        >
                        {{ $blog->subtitle }}
                    </p>
                @endif
                {{-- Hero Image --}}
                <img src="{{ asset('storage/' . $blog->image_url) }}"
                    alt="{{ $blog->title }}"
                    title="{{ $blog->title }}"
                    width="1200"
                    height="630"
                    class="img-fluid rounded-4 shadow-sm mb-5 w-100"
                    style="max-height:500px; object-fit:cover;" loading="eager"
                    fetchpriority="high"
                    itemprop="image">

                {{-- Tags --}}
                @if($blog->tags)
                    <div class="mb-3">

                        @foreach(explode(',', $blog->tags) as $tag)

                            <span class="badge bg-primary-subtle text-primary border me-2">
                                {{ trim(str_replace('#', '', $tag)) }}
                            </span>

                        @endforeach

                    </div>
                @endif

                {{-- Meta --}}
                <div class="d-flex align-items-center text-muted border-top border-bottom py-3 mb-5">

                    <span
                        itemprop="author"
                        itemscope
                        itemtype="https://schema.org/Person"
                    >
                        <strong itemprop="name">
                            {{ $blog->author->name ?? 'OwnAcres' }}
                        </strong>
                    </span>

                    <span class="mx-3">•</span>
                    <span>

                    {{ max(1, ceil(str_word_count(strip_tags($blog->content)) / 200)) }} min read

                    </span>

                    <span class="mx-3">•</span>

                    <time
                        datetime="{{ \Carbon\Carbon::parse($blog->date_published)->toDateString() }}"
                        itemprop="datePublished"
                    >
                        {{ \Carbon\Carbon::parse($blog->date_published)->format('F d, Y') }}
                    </time>

                </div>

                {{-- Content --}}
                <section
                    class="blog-content fs-5 lh-lg"
                    itemprop="articleBody"
                >

                    {!! $blog->content !!}

                </section>

            </div>

        </div>
    </article>
</main>

@endsection