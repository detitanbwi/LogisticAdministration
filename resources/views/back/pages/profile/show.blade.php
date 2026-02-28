@extends('back.layouts.app')

@section('title', 'Profile Details')

@section('page_title', 'Profile Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.profile.show') }}">Profile Details</a></li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 col-xl-6">
            <div class="card stretch stretch-full">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Profile Information</h5>
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-sm btn-primary">
                        <i class="feather-edit pb-1 me-1"></i> Edit Profile
                    </a>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        @if($user->photo)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($user->photo) }}"
                                class="rounded-circle border border-2 border-primary me-3"
                                style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="avatar-text avatar-xl bg-soft-primary text-primary me-3 border border-2 border-primary">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <p class="mb-0 text-muted">{{ $user->email }}</p>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 py-3 d-flex align-items-center justify-content-between">
                            <span class="text-muted fw-medium">Nama Lengkap</span>
                            <span class="fw-bold">{{ $user->name }}</span>
                        </li>
                        <li class="list-group-item px-0 py-3 d-flex align-items-center justify-content-between">
                            <span class="text-muted fw-medium">Email Address</span>
                            <span class="fw-bold">{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item px-0 py-3 d-flex align-items-center justify-content-between">
                            <span class="text-muted fw-medium">Member Since</span>
                            <span class="fw-bold">{{ $user->created_at->format('d F Y') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection