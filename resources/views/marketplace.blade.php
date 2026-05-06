@extends('layouts.app')
@section("content")
    @include("components.show_properties", ['properties' => $properties])
@endsection