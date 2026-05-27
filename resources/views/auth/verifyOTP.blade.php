@extends('layouts.app')
@section('content')
<div class="container mt-5 mb-5">
    <div class="col-md-5 mx-auto">
        <div class="card p-4 border-0 bg-light">

            <h3 class="mb-3 text-center">Verify OTP</h3>

            <!-- ERROR DISPLAY -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register.verifyOTP') }}">
                @csrf
                <div class="mb-3">
                    <label>Enter OTP</label>
                    <input class="form-control" type="text" name="otp">
                </div>

                <button class="btn btn-primary w-100">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection