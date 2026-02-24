@extends('back.layouts.app')

@section('title', 'Profile Details')

@section('page_title', 'Profile Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.profile.edit') }}">Profile Details</a></li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 col-xl-6">
            <div class="card stretch stretch-full">
                <div class="card-header">
                    <h5 class="card-title">Update Profile Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-back.text-input label="Nama Lengkap" name="name" :value="$user->name" required />
                        </div>

                        <div class="mb-4">
                            <x-back.text-input type="email" label="Email Address" name="email" :value="$user->email"
                                required />
                        </div>

                        <div class="mb-4">
                            <x-back.text-input type="password" label="New Password (kosongkan jika tidak ingin merubah)"
                                name="password" />
                            <small class="text-muted">Minimum 8 characters</small>
                        </div>

                        <div class="mb-4">
                            <x-back.text-input type="password" label="Confirm New Password" name="password_confirmation" />
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
