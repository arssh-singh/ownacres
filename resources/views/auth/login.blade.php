@extends('layouts.app')
@section('content')
<div class="container pt-lg-5 pt-sm-0 mt-5 mb-5">
    <div class="col-md-5 mx-auto">
        <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4">

            <h3 class="fw-bold text-center mb-1">Log In</h3>
            <p class="text-muted text-center small mb-4">Enter your details to access your account</p>

            <!-- ERROR DISPLAY -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control py-2" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com">
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input class="form-control py-2" type="password" name="password" placeholder="••••••••">
                </div>

                <button class="btn btn-primary w-100 py-2 fw-semibold">Login</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('forgotpass.form') }}" class="small text-decoration-none">Forgot Password?</a>
            </div>

        </div>
    </div>
</div>
@endsection