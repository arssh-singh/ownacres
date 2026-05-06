@extends('layouts.app')
@section('content')
    @include('components.index_components.hero')
    @include('components.show_properties', ['properties' => $properties])
    @include('components.index_components.philosophy')
    @include('components.index_components.contact')
@endsection