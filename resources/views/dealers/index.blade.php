@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Property Dealers</h2>
            <p class="text-muted mb-0">
                Browse verified property dealers on OwnAcres.
            </p>
        </div>

        <span class="badge bg-primary fs-6">
            {{ $dealers->count() }} Dealers
        </span>
    </div>

    <div class="row g-4">

        @forelse($dealers as $dealer)

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body text-center">

                        <img src="{{ $dealer->profile_image_url }}"
                             alt="{{ $dealer->name }}"
                             class="rounded-circle shadow-sm mb-3"
                             width="100"
                             height="100"
                             style="object-fit: cover;">

                        <h5 class="fw-bold mb-1">
                            {{ $dealer->name }}
                        </h5>

                        <p class="text-muted small mb-3">
                            {{ $dealer->profile->headline ?? 'Real Estate Dealer' }}
                        </p>
                        <p class="text-muted small mb-3">
                            {{ $dealer->profile->bio ?? 'Real Estate Dealer' }}
                        </p>

                        <a href="{{ route('dealer.profile', $dealer->id) }}"
                           class="btn btn-primary rounded-pill px-4">
                            View Profile
                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-light border text-center py-5">
                    <h5 class="mb-2">No dealers found</h5>
                    <p class="text-muted mb-0">
                        There are currently no registered property dealers.
                    </p>
                </div>
            </div>

        @endforelse

    </div>

</div>
@endsection