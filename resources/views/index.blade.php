@extends('layouts.app')
@section('content')
    @include('components.index_components.hero')
    <div class="container-fluid px-lg-5 px-sm-0 mb-5">
        <div class="row">
            <!-- LEFT SIDE -->
            <div class="col-lg-8">
                @include('components.index_components.properties', ['properties' => $properties])
                @include('components.index_components.browse')
                <section class="py-5">
                    <div class="container-fluid px-sm-0">

                        <!-- <p class="text-uppercase text-secondary small fw-semibold mb-2" style="letter-spacing:.1em">Why Ownacres</p>
                        <h2 class="fw-medium mb-1" style="font-size:28px">Everything you need,<br>in one place</h2> -->

                        <div class="row g-4">

                        @foreach([
                            ['bi-person',     '#E1F5EE', '#0F6E56', 'Verified listings',   'Every property is manually reviewed before going live — no duplicates, no fake listings.',  '98%',  'Accuracy rate'],
                            ['bi-house',  '#EEEDFE', '#534AB7', 'Largest inventory',   'Browse thousands of houses, apartments, villas and plots across 8+ cities in Pakistan.',    '12k+', 'Active listings'],
                            ['bi-person-square',            '#FAEEDA', '#854F0B', 'Trusted advisors',    'Our agents guide you from the first search all the way through to the final handover.',      '500+', 'Happy clients'],
                            ['bi-currency-rupee',   '#FAECE7', '#993C1D', 'Best market prices',  'We negotiate on your behalf and match you to properties that fit your budget and goals.',    'No',   'Hidden fees'],
                        ] as [$icon, $iconBg, $iconColor, $title, $desc, $stat, $statLabel])
                        <div class="col-lg-3 col-sm-6">
                            <div class="border rounded-4 p-4 h-100 bg-white">

                            <div class="rounded-3 d-inline-flex align-items-center justify-content-center mb-4"
                                style="width:44px; height:44px; background:{{ $iconBg }}">
                                <i class="bi {{ $icon }}" style="font-size:20px; color:{{ $iconColor }}"></i>
                            </div>

                            <h3 class="fw-medium mb-2" style="font-size:15px">{{ $title }}</h3>
                            <p class="text-secondary mb-4" style="font-size:13px">{{ $desc }}</p>

                            <div class="border-top pt-3 mt-auto">
                                <p class="fw-medium mb-0" style="font-size:22px">{{ $stat }}</p>
                                <p class="text-secondary mb-0" style="font-size:11px">{{ $statLabel }}</p>
                            </div>

                            </div>
                        </div>
                        @endforeach

                        </div>
                    </div>
                </section>
            </div>
            <div class="col-lg-4 mt-5">
                @include('components.index_components.new_user_form')
            </div>
        </div>
    </div>
    @include('components.index_components.dealers')

    <!-- @nclude('components.show_properties', ['properties' => $properties]) -->
    <!-- @nclude('components.index_components.philosophy')
    @nclude('components.index_components.contact') -->
@endsection