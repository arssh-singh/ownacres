@extends('layouts.user')
@section('content')
<div class="p-2">
    <p class="text-primary">DASHBOARD OVERVIEW</p>
    <p class="text-muted">Welcome back, {{ auth()->user()->name }}! Here's a quick overview of your dashboard.</p>

    <div class="table-responsive mt-3">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Beds</th>
                    <th>Baths</th>
                    <th>Sqft</th>                    
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($properties as $property)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $property->image) }}"
                            style="width:80px; height:60px; object-fit:cover;" class="rounded">
                    </td>
                    <td>{{ $property->title }}</td>
                    <td>${{ number_format($property->price, 2) }}</td>
                    <td>{{ $property->location }}</td>
                    <td>{{ $property->bedrooms }}</td>
                    <td>{{ $property->bathrooms }}</td>
                    <td>{{ $property->area }}</td>                    
                    <td><a href="{{route("properties.edit", $property->id)}}">Edit</a></td>
                    <td><a>Delete</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection