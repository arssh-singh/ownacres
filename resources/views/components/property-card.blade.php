@props([
    'property',
    'image',
    'title',
    'description',
    'href' => '#',
    'status' => 'draft', // draft | archived | published
    'editHref' => '#',
    'delHref' => '#',
])

@php
    $statusMap = [
        'draft' => ['label' => 'Draft', 'class' => 'bg-secondary'],
        'archived' => ['label' => 'Archived', 'class' => 'bg-dark'],
        'published' => ['label' => 'Published', 'class' => 'bg-success'],
    ];
    $statusInfo = $statusMap[$status] ?? $statusMap['draft'];
@endphp

<div class="card shadow-sm position-relative" 
     style="cursor: pointer; max-width: 320px;" 
     onclick="window.location='{{ $href }}'">

    <img src="{{ $image }}" class="card-img-top" alt="{{ $title }}" 
         style="height: 180px; object-fit: cover;">

    {{-- Status badge, top-left --}}
    <span class="badge {{ $statusInfo['class'] }} position-absolute top-0 start-0 m-2">
        {{ $statusInfo['label'] }}
    </span>

    {{-- 3-dot menu, stops click from bubbling to card --}}
    <div class="dropdown position-absolute top-0 end-0 m-2" onclick="event.stopPropagation()">
        <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button" 
                data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-three-dots-vertical"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ $editHref }}">Edit</a></li>

            @if ($status !== 'published')
                <li>
                    <form action="{{ route('properties.updateStatus', $property->id ?? '') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="published">
                        <button type="submit" class="dropdown-item">Make Public</button>
                    </form>
                </li>
            @endif

            @if ($status !== 'draft')
                <li>
                    <form action="{{ route('properties.updateStatus', $property->id ?? '') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="draft">
                        <button type="submit" class="dropdown-item">Make Draft</button>
                    </form>
                </li>
            @endif

            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ $delHref }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item text-danger">
                        Delete
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <h5 class="card-title mb-1">{{ $title }}</h5>
        <p class="card-text text-muted small mb-0">{{ $description }}</p>
    </div>
</div>