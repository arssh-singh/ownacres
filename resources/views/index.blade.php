@extends('layouts.app')
@section('content')
    @include('sections.index.hero')
    <div class="container-fluid px-lg-5 px-sm-0 mb-5">
        <div class="row">
            <!-- LEFT SIDE -->
            <div class="col-lg-8">
                @include('sections.index.properties', ['properties' => $properties])
                @include('sections.index.browse')
                {{-- @include('sections.index.aboutus') --}}
            </div>
            <div class="col-lg-4 mt-5">
                @include('sections.index.new_user_form')
            </div>
        </div>
    </div>
    {{-- @include('sections.index.dealers') --}}
@endsection