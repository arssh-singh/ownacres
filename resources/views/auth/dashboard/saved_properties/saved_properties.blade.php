@extends('layouts.user')

@section('content')
<div class="container py-5">

    {{-- ───────── Page Header ───────── --}}
    <div class="d-flex align-items-end justify-content-between mb-4 pb-3 border-bottom">
        <div>
            <p class="sp-eyebrow mb-1">Your Collection</p>
            <h1 class="sp-page-title mb-0">Saved Properties</h1>
        </div>
        <span class="sp-count-badge">
            {{ $properties->count() }} {{ Str::plural('property', $properties->count()) }}
        </span>
    </div>

    {{-- ───────── Empty State ───────── --}}
    @if($properties->isEmpty())
    <div class="sp-empty text-center mx-auto py-5">
        <div class="sp-empty-icon mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
            </svg>
        </div>
        <h2 class="fw-semibold mb-2">No saved properties yet</h2>
        <p class="text-muted mb-4">Browse listings and bookmark the ones you love — they'll appear here.</p>
        <a href="{{ route('marketplace') }}" class="btn sp-btn-primary px-4 py-2">Explore Properties</a>
    </div>

    {{-- ───────── Property Grid ───────── --}}
    @else
    <div class="row g-4">
        @foreach($properties as $property)
        <div class="col-12 col-md-6 col-xl-4 sp-card-col" data-id="{{ $property->id }}">
            <article class="sp-card h-100">

                {{-- Image --}}
                <div class="sp-card-img-wrap">
                    <img
                        src="{{ asset('storage/' . $property->image) }}"
                        alt="{{ $property->title }}"
                        class="sp-card-img"
                        loading="lazy"
                    >
                    {{-- Badge --}}
                    <div class="sp-badges">
                        @if($property->is_furnished)
                        <span class="sp-badge sp-badge-furnished">Furnished</span>
                        @else
                        <span class="sp-badge sp-badge-unfurnished">Unfurnished</span>
                        @endif
                    </div>
                    {{-- Remove --}}
                    <form action="{{ route('properties.save', $property->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button
                            type="submit"
                            class="sp-remove-btn"
                            title="Remove from saved"
                            aria-label="Remove {{ $property->title }} from saved"
                        >
                            <i class="bi bi-bookmark-x-fill"></i>
                        </button>
                    </form>
                </div>

                {{-- Body --}}
                <div class="sp-card-body">
                    <h2 class="sp-card-title">{{ $property->title }}</h2>
                    <p class="sp-card-desc text-muted">{{ Str::limit($property->description, 90) }}</p>

                    {{-- Meta --}}
                    <div class="sp-meta mt-auto pt-3">
                        <span class="sp-meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="15" height="15">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.126 1.126 0 0 1 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            {{ $property->bedrooms }} Bed
                        </span>
                        <span class="sp-meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="15" height="15">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            {{ $property->bathrooms }} Bath
                        </span>
                        <span class="sp-meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="15" height="15">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                            </svg>
                            {{ number_format($property->area) }} ft²
                        </span>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="sp-card-footer d-flex align-items-center justify-content-between">
                    <div>
                        <div class="sp-price-label">Price</div>
                        <div class="sp-price-value">${{ number_format($property->price) }}</div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="sp-date text-muted">
                            {{ \Carbon\Carbon::parse($property->created_at)->format('M d, Y') }}
                        </span>
                        <a href="{{ route('properties.prop_details', $property->id) }}" class="btn sp-btn-outline btn-sm">
                            View
                        </a>
                    </div>
                </div>

            </article>
        </div>
        @endforeach
    </div>
    @endif

</div>

<style>
/* ── Accent token (one place to change) ── */
:root {
    --sp-accent:      #2563EB;
    --sp-accent-lt:   #EFF6FF;
    --sp-accent-mid:  #BFDBFE;
    --sp-green:       #059669;
    --sp-green-lt:    #ECFDF5;
    --sp-radius:      12px;
    --sp-shadow:      0 2px 16px rgba(0,0,0,.07);
    --sp-shadow-hover:0 8px 32px rgba(37,99,235,.12);
}

/* ── Header ── */
.sp-eyebrow {
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--sp-accent);
}
.sp-page-title {
    font-size: clamp(1.5rem, 3.5vw, 2rem);
    font-weight: 700;
    letter-spacing: -.02em;
    color: #0F172A;
}
.sp-count-badge {
    font-size: .8rem;
    font-weight: 500;
    color: #64748B;
    background: #F1F5F9;
    border: 1px solid #E2E8F0;
    padding: .35rem .9rem;
    border-radius: 999px;
}

/* ── Card ── */
.sp-card {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: var(--sp-radius);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: var(--sp-shadow);
    transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
}
.sp-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--sp-shadow-hover);
    border-color: var(--sp-accent-mid);
}

/* ── Image ── */
.sp-card-img-wrap {
    position: relative;
    height: 210px;
    overflow: hidden;
    flex-shrink: 0;
    background: #F8FAFC;
}
.sp-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .45s ease;
}
.sp-card:hover .sp-card-img { transform: scale(1.05); }

/* ── Badges ── */
.sp-badges {
    position: absolute;
    top: .75rem;
    left: .75rem;
}
.sp-badge {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .07em;
    text-transform: uppercase;
    padding: .28rem .65rem;
    border-radius: 999px;
}
.sp-badge-furnished {
    background: var(--sp-green-lt);
    color: var(--sp-green);
    border: 1px solid #A7F3D0;
}
.sp-badge-unfurnished {
    background: #F8FAFC;
    color: #64748B;
    border: 1px solid #E2E8F0;
}

/* ── Remove button ── */
.sp-remove-btn {
    position: absolute;
    top: .75rem;
    right: .75rem;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255,255,255,.9);
    backdrop-filter: blur(4px);
    border: 1px solid #E2E8F0;
    color: var(--sp-accent);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s, color .2s, border-color .2s, transform .2s;
    padding: 0;
}
.sp-remove-btn:hover {
    background: #FEE2E2;
    color: #DC2626;
    border-color: #FECACA;
    transform: scale(1.1);
}

/* ── Card body ── */
.sp-card-body {
    padding: 1.1rem 1.25rem .9rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: .45rem;
}
.sp-card-title {
    font-size: .95rem;
    font-weight: 600;
    color: #0F172A;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin: 0;
}
.sp-card-desc {
    font-size: .78rem;
    line-height: 1.6;
    margin: 0;
}

/* ── Meta ── */
.sp-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    border-top: 1px solid #F1F5F9;
}
.sp-meta-item {
    display: flex;
    align-items: center;
    gap: .3rem;
    font-size: .75rem;
    color: #64748B;
    font-weight: 500;
}
.sp-meta-item svg { opacity: .65; flex-shrink: 0; }

/* ── Card footer ── */
.sp-card-footer {
    padding: .85rem 1.25rem;
    background: #F8FAFC;
    border-top: 1px solid #F1F5F9;
}
.sp-price-label {
    font-size: .62rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #94A3B8;
    margin-bottom: .05rem;
}
.sp-price-value {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--sp-accent);
    letter-spacing: -.01em;
    line-height: 1;
}
.sp-date {
    font-size: .7rem;
    white-space: nowrap;
}

/* ── Buttons ── */
.sp-btn-primary {
    background: var(--sp-accent);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: .9rem;
    transition: background .2s, transform .15s;
}
.sp-btn-primary:hover { background: #1D4ED8; color: #fff; transform: translateY(-1px); }

.sp-btn-outline {
    background: var(--sp-accent-lt);
    color: var(--sp-accent);
    border: 1px solid var(--sp-accent-mid);
    border-radius: 7px;
    font-weight: 600;
    font-size: .75rem;
    transition: background .2s;
}
.sp-btn-outline:hover { background: var(--sp-accent-mid); color: var(--sp-accent); }

/* ── Empty state ── */
.sp-empty { max-width: 380px; }
.sp-empty-icon {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    background: var(--sp-accent-lt);
    border: 1px solid var(--sp-accent-mid);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--sp-accent);
}
.sp-empty-icon svg { width: 32px; height: 32px; }

/* ── Remove animation ── */
.sp-card-col.removing { animation: spFadeOut .3s ease forwards; }
@keyframes spFadeOut { to { opacity: 0; transform: scale(.97) translateY(5px); } }

@media (prefers-reduced-motion: reduce) {
    .sp-card, .sp-card-img, .sp-remove-btn { transition: none !important; }
    .sp-card-col.removing { animation: none; opacity: 0; }
}
</style>

<script>
function removeSaved(id, btn) {
    const col = btn.closest('.sp-card-col');
    col.classList.add('removing');

    fetch(`/saved-properties/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(res => { if (!res.ok) throw new Error(); return res.json(); })
    .then(() => {
        setTimeout(() => {
            col.remove();
            const remaining = document.querySelectorAll('.sp-card-col').length;
            const countEl = document.querySelector('.sp-count-badge');
            if (countEl) countEl.textContent = `${remaining} ${remaining === 1 ? 'property' : 'properties'}`;
            if (remaining === 0) location.reload();
        }, 300);
    })
    .catch(() => {
        col.classList.remove('removing');
        alert('Could not remove property. Please try again.');
    });
}
</script>
@endsection