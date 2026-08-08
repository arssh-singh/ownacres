@extends('layouts.user')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">My Blogs</h2>
            <p class="text-muted mb-0">
                Manage your drafts and published articles.
            </p>
        </div>

        <form action="{{ route('blog.store') }}" method="POST">
            @csrf
            <button class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>
                New Blog
            </button>
        </form>
    </div>

    @if($blogs->isEmpty())

        <div class="text-center py-5">
            <i class="bi bi-journal-richtext display-3 text-secondary"></i>

            <h3 class="mt-3">No blogs yet</h3>

            <p class="text-muted">
                Create your first article to get started.
            </p>
        </div>

    @else

        <div class="row g-4">

        @foreach($blogs as $blog)

            <div class="col-md-6 col-xl-4">

                <div class="card h-100 border-0 shadow-sm">

                    {{-- Featured image --}}
                    <div
                        class="bg-light d-flex align-items-center justify-content-center position-relative"
                        style="height:220px;"
                    >

                        <img
                            class="img-fluid w-100 h-100 object-fit-cover"
                            src="{{ asset('/storage/' . $blog->image_url) }}"
                            alt="{{ $blog->title }}"
                        >

                        {{-- Menu --}}
                        <div class="dropdown position-absolute top-0 end-0 m-2">

                            <button
                                class="btn btn-light btn-sm rounded-circle shadow-sm"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>
                                    <a
                                        href="{{ route('blog.edit', $blog) }}"
                                        class="dropdown-item"
                                    >
                                        <i class="bi bi-pencil me-2"></i>
                                        Edit
                                    </a>
                                </li>

                                <li>
                                    <a
                                        href="{{ route('blogs.show', ['blog' => $blog->id]) }}"
                                        class="dropdown-item"
                                    >
                                        <i class="bi bi-eye me-2"></i>
                                        View
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                {{-- Publish / Draft --}}
                                <li>
                                    <form
                                        action="{{ route('blog.status', $blog) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="{{ $blog->status === 'published' ? 'draft' : 'published' }}"
                                        >

                                        <button type="submit" class="dropdown-item">
                                            @if($blog->status === 'published')
                                                <i class="bi bi-file-earmark me-2"></i>
                                                Move to Draft
                                            @else
                                                <i class="bi bi-check-circle me-2"></i>
                                                Publish
                                            @endif
                                        </button>
                                    </form>
                                </li>

                                @if($blog->status !== 'archived')
                                    <li>
                                        <form
                                            action="{{ route('blog.status', $blog) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <input
                                                type="hidden"
                                                name="status"
                                                value="archived"
                                            >

                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-archive me-2"></i>
                                                Archive
                                            </button>
                                        </form>
                                    </li>
                                @endif

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                {{-- Delete --}}
                                <li>
                                    <form
                                        action="{{ route('blog.destroy', $blog) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this blog?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="dropdown-item text-danger"
                                        >
                                            <i class="bi bi-trash me-2"></i>
                                            Delete
                                        </button>
                                    </form>
                                </li>

                            </ul>

                        </div>

                    </div>

                    <div class="card-body d-flex flex-column">

                        <div class="mb-3">

                            @switch($blog->status)

                                @case('published')
                                    <span class="badge bg-success">
                                        Published
                                    </span>
                                    @break

                                @case('draft')
                                    <span class="badge bg-warning text-dark">
                                        Draft
                                    </span>
                                    @break

                                @case('archived')
                                    <span class="badge bg-secondary">
                                        Archived
                                    </span>
                                    @break

                            @endswitch

                        </div>

                        <h5 class="fw-bold">
                            {{ $blog->title ?: 'Untitled Draft' }}
                        </h5>

                        <p class="text-muted flex-grow-1">
                            {{ $blog->subtitle ?: 'No subtitle yet.' }}
                        </p>

                        <div class="small text-muted mb-3">

                            <div>
                                Created:
                                {{ $blog->created_at->format('d M Y') }}
                            </div>

                            <div>
                                Updated:
                                {{ $blog->updated_at->diffForHumans() }}
                            </div>

                        </div>

                        <a
                            href="{{ route('blog.edit', $blog) }}"
                            class="btn btn-outline-primary w-100"
                        >
                            <i class="bi bi-pencil-square me-2"></i>
                            Edit Article
                        </a>

                    </div>

                </div>

            </div>

        @endforeach

        </div>

    @endif

</div>
@endsection