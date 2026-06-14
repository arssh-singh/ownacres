@extends('layouts.user')
@section('content')
<div class="container-fluid p-4 px-0">
    <h1 class="display-4">Create Property Listing</h1>
    <p class="step-desc" id="descp">Step 1: Adding Title and description</p>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 line p-0 bg-light" >
                <hr class="progress-bar p-0 m-0" id="progress-bar" style="width: 25%; border: solid 5px black;">
            </div>
        </div>
    </div>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
<div class="container-fluid p-4 bg-light">
    <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- STEP 1 -->
        <div class="step" id="step-1">
            <h4>Basic Info</h4>
            
            <input type="text" name="title" class="form-control mb-3" placeholder="Title">
            <textarea name="description" class="form-control mb-3" placeholder="Description"></textarea>
            
            <button type="button" onclick="nextStep(2)" class="btn btn-primary">Next</button>
        </div>
        
        <!-- STEP 2 -->
        <div class="step d-none" id="step-2">
            <h4>Details</h4>
            
            <input type="number" name="price" class="form-control mb-2" placeholder="Price">
            <input type="number" name="bedrooms" class="form-control mb-2" placeholder="Bedrooms">
            <input type="number" name="bathrooms" class="form-control mb-2" placeholder="Bathrooms">
            <input type="number" name="area" class="form-control mb-2" placeholder="Area (sq ft)">
            
            <button type="button" onclick="prevStep(1)" class="btn btn-secondary">Back</button>
            <button type="button" onclick="nextStep(3)" class="btn btn-primary">Next</button>
        </div>
        
        <!-- STEP 3 -->
        <div class="step d-none" id="step-3">
            <h4>Location</h4>
            
            <input type="text" name="location" class="form-control mb-3" placeholder="Location">
            
            <button type="button" onclick="prevStep(2)" class="btn btn-secondary">Back</button>
            <button type="button" onclick="nextStep(4)" class="btn btn-primary">Next</button>
        </div>
        
        <!-- STEP 4 -->
        <div class="step d-none" id="step-4">
            <h4>Media & Finish</h4>
            
            <input type="file" name="image" class="form-control mb-2" accept="image/png, image/jpeg">
            
            <select name="is_furnished" class="form-control mb-3">
                <option value="1">Furnished</option>
                <option value="0">Not Furnished</option>
            </select>
            
            <button type="button" onclick="prevStep(3)" class="btn btn-secondary">Back</button>
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
        
    </form>
</div>
<script>

    function nextStep(step) {
        document.querySelectorAll('.step').forEach(el => el.classList.add('d-none'));
        document.getElementById('step-' + step).classList.remove('d-none');
        
        let line_w = (step/4)*100;
        document.getElementById('progress-bar').style.width = line_w + "%";
    }

    function prevStep(step) {
        nextStep(step);
    }
</script>

@endsection