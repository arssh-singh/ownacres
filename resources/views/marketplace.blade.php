@extends('layouts.app')
@section("content")
    @include("components.properties", ['properties' => $properties])
@endsection