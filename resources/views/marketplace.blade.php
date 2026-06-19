@extends('layouts.app')
@section("content")
    <div class="container-fluid mt-5 pt-5 px-lg-5 px-sm-0" style="background-color: #f8f9fa; ">
        <div class="row">
                @include("sections.marketplace.filterbar")
            <div class="col-xl-9">
                @include("sections.marketplace.show_properties", ['properties' => $properties])
            </div>
        </div>
    </div>

@endsection