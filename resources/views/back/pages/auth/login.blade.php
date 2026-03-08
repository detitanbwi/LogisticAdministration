@extends('back.layouts.guest')
@section('title', 'Login')
@section('content')
    <h3 class="fs-18 fw-bolder mb-2 text-dark">Portal Administrator</h3>
    <p class="fs-13 fw-medium text-muted">Silakan masuk menggunakan email dan kata sandi Anda.</p>

    <form action="{{ route('admin.login.store') }}" class="w-100 mt-4" method="POST">
        @csrf

        <div class="mb-4">
            <x-back.text-input type="email" class="form-control" name="email" placeholder="Email or Username"
                :value="old('email')" required autofocus />
        </div>

        <div class="mb-3">
            <x-back.text-input type="password" class="form-control" name="password" placeholder="Password" required />
        </div>

        <div class="mb-4">
            <x-back.checkbox name="remember" label="Remember Me" />
        </div>



        <div class="mt-4">
            <x-back.button type="submit" variant="primary" size="lg" block class="w-100 fw-bold rounded-3">
                <i class="feather-log-in me-2"></i> Log In
            </x-back.button>
        </div>
    </form>


@endsection