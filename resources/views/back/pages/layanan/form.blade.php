@extends('back.layouts.app')

@section('title', isset($layanan) ? 'Edit Layanan' : 'Tambah Layanan')

@section('page_title', isset($layanan) ? 'Edit Layanan' : 'Tambah Layanan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.layanan.index') }}">Layanan</a></li>
    <li class="breadcrumb-item active">{{ isset($layanan) ? 'Edit Layanan' : 'Tambah Layanan' }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ isset($layanan) ? 'Edit Layanan' : 'Tambah Layanan' }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($layanan) ? route('admin.layanan.update', $layanan->id) : route('admin.layanan.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($layanan))
                            @method('PUT')
                        @endif

                        <x-back.text-input name="nama" label="Nama Layanan" :value="old('nama', $layanan->nama ?? '')" required
                            placeholder="Masukkan Nama Layanan" />

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <x-back.button variant="light-brand" :href="route('admin.layanan.index')">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Kembali</span>
                            </x-back.button>
                            <x-back.button type="submit">
                                <i class="feather-save me-2"></i>
                                <span>{{ isset($layanan) ? 'Simpan Perubahan' : 'Simpan Layanan' }}</span>
                            </x-back.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
