@extends('back.layouts.guest')
@section('title', 'Login')
@section('content')
    <h2 class="fs-20 fw-bolder mb-4">Login</h2>
    <h4 class="fs-13 fw-bold mb-2">Login to your account</h4>
    <p class="fs-12 fw-medium text-muted">Thank you for get back <strong>{{ config('app.name') }}</strong> web applications,
        let's access our the best recommendation for you.</p>

    <form action="{{ route('admin.login.store') }}" class="w-100 mt-4 pt-2" method="POST">
        @csrf

        <x-back.text-input type="email" class="form-control" name="email" placeholder="Email or Username" :value="old('email')"
            required autofocus />

        <x-back.text-input type="password" class="form-control" name="password" placeholder="Password" required />

        <div class="d-flex align-items-center justify-content-between">
            <div>
                <x-back.checkbox name="remember" label="Remember Me" />
            </div>
        </div>
        <div class="mt-5">
            <x-back.button type="submit" variant="primary" size="lg" block>
                Login
            </x-back.button>
        </div>
    </form>


@endsection
