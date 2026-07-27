@extends('layouts.app')
@section(
    'description',
    'Browse verified properties for sale and rent across India. Search houses, apartments, plots, villas, and commercial properties on OwnAcres.'
)

@section(
    'keywords',
    'properties for sale, properties for rent, real estate India, houses, apartments, plots, OwnAcres'
)

@section('canonical', route('marketplace'))

@section('og_type', 'website')

@section('og_title', 'Properties for Sale & Rent | OwnAcres')

@section(
    'og_description',
    'Browse verified properties for sale and rent across India.'
)

@section('og_image', asset('images/marketplace-og.jpg'))

@section('twitter_image', asset('images/marketplace-og.jpg'))
@section("content")
    <div class="container-fluid mt-5 pt-5 px-lg-5 px-sm-0" style="background-color: #f8f9fa; ">
        <div class="row">
                @include("sections.marketplace.filterbar")
            <div class="col-xl-9">

                <div id="propertiesContainer">
                    @include('partials.alerts')
                    @include("sections.marketplace.show_properties", ['properties' => $properties])
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
{{-- filters --}}
<script>
    let searchIds = @json($ids ?? []);
</script>
<script>
    const propertiesContainer = document.getElementById('propertiesContainer');
    const searchForm = document.getElementById('searchForm');
    const jsAlert = document.getElementById('jsAlert');
    const jsAlertMessage = document.getElementById('jsAlertMessage');


    searchForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await fetch('{{ route('search') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (!response.ok) {
                jsAlertMessage.textContent = data.error;
                jsAlert.classList.remove('d-none');
                jsAlert.classList.add('show');
                return;
            }

            // Hide any previous error
            jsAlert.classList.add('d-none');
            jsAlert.classList.remove('show');

            // Save vector search IDs
            searchIds = data.ids;

            console.log(searchIds);

            // Update properties
            propertiesContainer.innerHTML = data.html;

            // animateCards(propertiesContainer);

        } catch (error) {
            jsAlertMessage.textContent = 'Something went wrong. Please try again.';
            jsAlert.classList.remove('d-none');
            jsAlert.classList.add('show');

            console.error(error);
        }
    });
</script>
{{-- filters --}}
<script>
async function applyFilters() {

    const formData = new FormData(filterForm);

    searchIds.forEach(id => formData.append('ids[]', id));

    const response = await fetch('{{ route("search.filter") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    const data = await response.json();

    propertiesContainer.innerHTML = data.html;
}
const filterForm = document.getElementById('filterForm');

filterForm.addEventListener('change', applyFilters);
filterForm.addEventListener('submit', function (e) {
    e.preventDefault();
    applyFilters();
});
</script>
@endpush