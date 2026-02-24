@extends('back.layouts.app')

@section('title', isset($user) ? 'Edit User' : 'Tambah User')

@section('page_title', isset($user) ? 'Edit User' : 'Tambah User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">{{ isset($user) ? 'Edit User' : 'Tambah User' }}</li>
@endsection

@section('content')
    <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
        @csrf
        @if (isset($user))
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-lg-12">
                {{-- Section: Informasi User --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ isset($user) ? 'Edit User' : 'Tambah User' }}</h5>
                    </div>
                    <div class="card-body">
                        <x-back.text-input name="name" label="Nama Lengkap" :value="old('name', $user->name ?? '')" required />

                        <x-back.text-input type="email" name="email" label="Email Address" :value="old('email', $user->email ?? '')" required />

                        <div class="row">
                            <div class="col-md-6">
                                <x-back.text-input type="password" name="password" label="Password" :required="!isset($user)"
                                    placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin mengubah password' : '' }}" />
                            </div>
                            <div class="col-md-6">
                                <x-back.text-input type="password" name="password_confirmation" label="Konfirmasi Password"
                                    :required="!isset($user)" />
                            </div>
                        </div>

                        <x-back.select2 name="roles" label="Role" :selected="$userRole ?? null" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}"
                                    {{ old('roles', $userRole ?? '') == $role ? 'selected' : '' }}>
                                    {{ $role }}
                                </option>
                            @endforeach
                        </x-back.select2>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <x-back.button variant="light-brand" :href="route('admin.users.index')">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali</span>
                        </x-back.button>
                        <x-back.button type="submit">
                            <i class="feather-save me-2"></i>
                            <span>{{ isset($user) ? 'Simpan Perubahan' : 'Simpan User' }}</span>
                        </x-back.button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
