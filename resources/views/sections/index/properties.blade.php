<style>
    .property-image{
        width:100%;
        height:250px;
        object-fit:cover;
    }
</style>
<!-- <div class="container-fluid mt-5">
    <div class="d-flex">
        <div class="rounded-pill" style="border: solid 1px white;">
            <button class="btn fs-6 px-5 py-3 rounded-pill loc-btn-active">Buy in Ludhiana</button>
            <button class="btn fs-6 px-5 py-3 rounded-pill">Buy in Moga</button>
            <button class="btn fs-6 px-5 py-3 rounded-pill">Buy in Amritsar</button>
        </div>
    </div>
    <hr style="width: 65%;"/>
</div> -->

@php $properties = $properties ?? collect(); @endphp
<section class="mt-4">
    <div class="container-fluid">

        <h2 class="fw-semibold">Recommended Properties</h2>
        <p class="text-secondary mb-4">Especially for you</p>

        <div class="row g-4" >

            <!-- Property 1 -->
            @foreach ($properties as $property)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card border-0 bg-transparent"  onclick="window.location.href='{{ route('properties.prop_details', $property->id) }}'"">
                    <img src="{{ asset('storage/' . $property->image) }}"
                         class="card-img-top rounded-4 property-image"
                         alt="Property" style="view-transition-name: poster">

                    <div class="card-body px-0">
                        <p class="fs-4 mb-2" id="price">₹{{ number_format($property->price, 2) }}</p>

                        <p class="text-secondary mb-2">
                            {{ $property->title }}
                        </p>

                        <div class="d-flex justify-content-between small text-muted">
                            <span>🛏️{{$property->bedrooms}}</span><span>🚻{{$property->bathrooms}}</span><span>7200 sqft</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
