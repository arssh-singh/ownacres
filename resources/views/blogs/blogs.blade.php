@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,300;9..144,500;9..144,600&family=Inter:wght@400;500&display=swap" rel="stylesheet">

<style>
    .blog-heading { font-family: 'Fraunces', serif; letter-spacing: -0.01em; }
    .blog-eyebrow {
        font-size: .75rem;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #8a8a8a;
    }
    .blog-card {
        transition: box-shadow .3s ease;
    }
    .blog-card:hover {
        box-shadow: 0 12px 32px rgba(0,0,0,.08) !important;
    }
    .blog-card .img-wrap {
        overflow: hidden;
        height: 220px;
    }
    .blog-card .img-wrap img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        transition: transform .5s ease;
    }
    .blog-card:hover .img-wrap img {
        transform: scale(1.05);
    }
    .blog-card .card-title {
        font-family: 'Fraunces', serif;
        font-weight: 500;
        line-height: 1.25;
    }
    .read-link {
        font-family: 'Inter', sans-serif;
        font-size: .85rem;
        font-weight: 500;
        color: #14181c;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: .35rem;
    }
    .read-link .arrow {
        transition: transform .25s ease;
    }
    .read-link:hover .arrow {
        transform: translateX(4px);
    }
    .read-link::after {
        content: '';
        display: block;
        height: 1px;
        background: #14181c;
        width: 0;
        transition: width .25s ease;
        position: absolute;
    }
</style>
<style>
    /* ...existing styles... */

    .blog-card {
        position: relative; /* required for stretched-link to scope to this card */
        transition: box-shadow .3s ease;
        cursor: pointer;
    }
</style>
<div class="container py-5 mt-5">

    <div class="mb-5">
        <div class="blog-eyebrow mb-2">From OWNACRES</div>
        <h1 class="blog-heading fw-semibold display-6 mb-0">Insights &amp; Guides</h1>
    </div>

    <div class="row g-4">

        @foreach ($blogs as $blog)

            @php
                $wordCount = str_word_count(strip_tags($blog->content));
                $readMinutes = max(1, (int) ceil($wordCount / 200));
            @endphp

            <div class="col-lg-4 col-md-6">

                <a href="{{ route('blogs.show', ['blog' => $blog->id]) }}" class="text-decoration-none text-reset d-block h-100">

                    <div class="card border-0 shadow-sm h-100 rounded-0 blog-card">

                        <div class="img-wrap">
                            <img src="{{ asset('storage/' . $blog->image_url) }}"
                                alt="{{ $blog->title }}">
                        </div>

                        <div class="card-body d-flex flex-column p-4">

                            <div class="d-flex align-items-center gap-2 mb-2 blog-eyebrow">
                                <span>{{ \Carbon\Carbon::parse($blog->date_published)->format('M d, Y') }}</span>
                                <span>&middot;</span>
                                <span>{{ $readMinutes }} min read</span>
                            </div>

                            <h4 class="card-title fs-4 mb-2">
                                {{ $blog->title }}
                            </h4>

                            @if($blog->subtitle)
                                <p class="text-muted mb-2" style="font-size: .95rem;">
                                    {{ $blog->subtitle }}
                                </p>
                            @endif

                            <p class="text-secondary" style="font-size: .9rem;">
                                {{ \Illuminate\Support\Str::limit(strip_tags($blog->content), 130) }}
                            </p>

                            <div class="mt-auto pt-2">
                                <span class="read-link">
                                    Read article <span class="arrow">→</span>
                                </span>
                            </div>

                        </div>

                    </div>

                </a>

            </div>

        @endforeach

    </div>

</div>

@endsection