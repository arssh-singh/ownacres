@extends('layouts.app')
@section('content')
<div class="container mt-5 mb-5">
    <div class="col-md-5 mx-auto">
        <div class="card p-4 border-0 bg-light">

            <h3 class="mb-3 text-center">Reset Password</h3>

            <!-- ERROR DISPLAY -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('forgotpass.changepass') }}">
                @csrf
                <div class="mb-3">
                    <label>New Password</label>
                    <input class="form-control" type="password" name="password" >
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input class="form-control" type="password" name="password_confirmation">
                </div>

                <button class="btn btn-primary w-100">Confirm</button>
            </form>
        </div>
    </div>
</div>
@endsection