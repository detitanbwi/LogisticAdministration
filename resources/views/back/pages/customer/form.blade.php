@extends('back.layouts.app')

@section('title', isset($customer) ? 'Edit Customer' : 'Tambah Customer')

@section('page_title', isset($customer) ? 'Edit Customer' : 'Tambah Customer')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}">Customer</a></li>
    <li class="breadcrumb-item active">{{ isset($customer) ? 'Edit Customer' : 'Tambah Customer' }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ isset($customer) ? 'Edit Customer' : 'Tambah Customer' }}</h5>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($customer) ? route('admin.customer.update', $customer->id) : route('admin.customer.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($customer))
                            @method('PUT')
                        @endif

                        <x-back.text-input name="nama" label="Nama Customer" :value="old('nama', $customer->nama ?? '')" required
                            placeholder="Masukkan Nama Customer" />

                        <div class="row">
                            <div class="col-md-6">
                                <x-back.text-input name="no_hp" label="Nomor HP" :value="old('no_hp', $customer->no_hp ?? '')" required
                                    placeholder="Masukkan Nomor HP" />
                            </div>
                            <div class="col-md-6">
                                <x-back.text-input name="npwp" label="NPWP" :value="old('npwp', $customer->npwp ?? '')"
                                    placeholder="Masukkan NPWP" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-back.text-input name="pic" label="Nama PIC" :value="old('pic', $customer->pic ?? '')"
                                    placeholder="Masukkan Nama PIC" />
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jabatan PIC</label>
                                    <select name="jabatan_pic" class="form-select">
                                        <option value="">Pilih Jabatan</option>
                                        <option value="Manager" {{ old('jabatan_pic', $customer->jabatan_pic ?? '') == 'Manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="Staff" {{ old('jabatan_pic', $customer->jabatan_pic ?? '') == 'Staff' ? 'selected' : '' }}>Staff</option>
                                        <option value="Owner" {{ old('jabatan_pic', $customer->jabatan_pic ?? '') == 'Owner' ? 'selected' : '' }}>Owner</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <x-back.textarea name="alamat" label="Alamat" :value="old('alamat', $customer->alamat ?? '')" placeholder="Masukkan Alamat" />

                        <x-back.textarea name="catatan" label="Catatan" :value="old('catatan', $customer->catatan ?? '')" placeholder="Masukkan Catatan" />

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <x-back.button variant="light-brand" :href="route('admin.customer.index')">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Kembali</span>
                            </x-back.button>
                            <x-back.button type="submit">
                                <i class="feather-save me-2"></i>
                                <span>{{ isset($customer) ? 'Simpan Perubahan' : 'Simpan Customer' }}</span>
                            </x-back.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
