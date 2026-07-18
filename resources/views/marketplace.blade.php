@extends('layouts.app')
@section("content")
    <div class="container-fluid mt-5 pt-5 px-lg-5 px-sm-0" style="background-color: #f8f9fa; ">
        <div class="row">
                @include("sections.marketplace.filterbar")
            <div class="col-xl-9">

                <div id="propertiesContainer">
                    @include("sections.marketplace.show_properties", ['properties' => $properties])
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
{{-- filters --}}
<script>
    // Search Logic
    const prop_container = document.getElementById('propertiesContainer')
    // document.addEventListener("DOMContentLoaded", animateCards(prop_container));

    const searchForm = document.getElementById('searchForm')
    searchForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        const response = await fetch(
            '{{ route('marketplace.properties.search') }}',
            {
                method: "POST",
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        );

        const properties = await response.json();
        console.log(properties.query);
        // document.getElementById('propertiesContainer').innerHTML = `<pre>${JSON.stringify(properties.html, null, 2)}</pre>`;
        document.getElementById('propertiesContainer').innerHTML = properties.html;
        
        // animateCards(prop_container);

    });
</script>
@endpush