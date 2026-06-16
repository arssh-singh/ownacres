@extends('layouts.user')

@section('content')
@php
    $avatarColors = [
        ['bg' => '#E6F1FB', 'text' => '#0C447C'],
        ['bg' => '#EAF3DE', 'text' => '#27500A'],
        ['bg' => '#FAEEDA', 'text' => '#633806'],
        ['bg' => '#FBEAF0', 'text' => '#72243E'],
    ];
@endphp

@foreach($inquiries as $inquiry)
    @php
        $initials = collect(explode(' ', $inquiry->user->name))
            ->map(fn($w) => strtoupper($w[0]))
            ->take(2)
            ->implode('');
        $color = $avatarColors[$loop->index % count($avatarColors)];
    @endphp

    <div class="card border-0 shadow-sm mb-3" style="border-radius: 14px;">
        <div class="card-body p-3">

            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-semibold flex-shrink-0"
                     style="width:46px;height:46px;background:{{ $color['bg'] }};color:{{ $color['text'] }};font-size:15px;">
                    {{ $initials }}
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <div class="fw-semibold text-dark mb-0" style="font-size:15px;">{{ $inquiry->user->name }}</div>
                    <div class="text-muted d-flex align-items-center gap-1" style="font-size:13px;">
                        <i class="bi bi-envelope"></i>
                        {{ $inquiry->user->email }}
                    </div>
                </div>
                <span class="badge rounded-pill text-muted bg-light fw-normal" style="font-size:12px;">
                    {{ $inquiry->created_at->diffForHumans() }}
                </span>
            </div>

            <div class="border-top pt-3">
                <p class="text-secondary mb-0" style="font-size:14px;line-height:1.6;">
                    {{ $inquiry->message }}
                </p>
            </div>

            <div class="d-flex gap-2 mt-3">
                <a href="" class="btn btn-sm btn-primary px-3">Reply</a>
                <button class="btn btn-sm btn-outline-secondary px-3">Mark read</button>
            </div>

        </div>
    </div>
@endforeach
@endsection