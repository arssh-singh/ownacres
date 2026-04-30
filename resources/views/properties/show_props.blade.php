@extends('layouts.user')
@section('content')
<div class="p-2">
    <p class="text-primary">DASHBOARD OVERVIEW</p>
    <h1 class="fs-1 fw-bold"></h1>
    <p class="text-muted">Welcome back, {{ auth()->user()->name }}! Here's a quick overview of your dashboard.</p>
    @foreach ($properties as $property)
        <div class="row g-4 mt-2">
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">{{ $property->title }}</h5>
                        <p class="card-text display-4">${{ number_format($property->price, 2) }}</p>
                        <a href="" class="btn btn-primary">View Properties</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
