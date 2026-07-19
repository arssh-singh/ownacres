@extends("layouts.app")
@section("content")
<div class="container mt-5 pt-5 mb-5">
    <div class="col-md-5 mx-auto">
        <div class="card p-4 border-0 bg-white">

            <h3 class="mb-3 text-center">Create Account</h3>

            <!-- ERROR DISPLAY -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register.sendOtp') }}">
                @csrf

                <div class="mb-3">
                    <label>Name</label>
                    <input class="form-control" type="text" name="name" value="{{ old('name', request('name')) }}" placeholder="John Doe">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email', request('email')) }}" placeholder="example@email.com">
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" placeholder="********">
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input class="form-control" type="password" name="password_confirmation">
                </div>

                <button class="btn btn-primary w-100">Register</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}">Already have an account?</a>
            </div>

        </div>
    </div>
</div>
@endsection