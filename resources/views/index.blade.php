@extends('layouts.app')
@section('content')
    @include('components.index_components.hero')
    <div class="container-fluid px-lg-5 px-sm-0">
        <div class="row">
            <!-- LEFT SIDE -->
            <div class="col-lg-8">
                @include('components.index_components.properties', ['properties' => $properties])
                @include('components.index_components.browse')
            </div>
            <div class="col-lg-4 mt-5">
                @include('components.index_components.new_user_form')
            </div>
        </div>
    </div>
    <!-- @nclude('components.show_properties', ['properties' => $properties]) -->
    <!-- @nclude('components.index_components.philosophy')
    @nclude('components.index_components.contact') -->
@endsection