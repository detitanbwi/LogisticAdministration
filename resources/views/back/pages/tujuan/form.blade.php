@extends('back.layouts.app')

@section('title', isset($tujuan) ? 'Edit Tujuan' : 'Tambah Tujuan')

@section('page_title', isset($tujuan) ? 'Edit Tujuan' : 'Tambah Tujuan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.tujuan.index') }}">Tujuan</a></li>
    <li class="breadcrumb-item active">{{ isset($tujuan) ? 'Edit Tujuan' : 'Tambah Tujuan' }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ isset($tujuan) ? 'Edit Tujuan' : 'Tambah Tujuan' }}</h5>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($tujuan) ? route('admin.tujuan.update', $tujuan->id) : route('admin.tujuan.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($tujuan))
                            @method('PUT')
                        @endif

                        <x-back.text-input name="nama_tujuan" label="Nama Tujuan" :value="old('nama_tujuan', $tujuan->nama_tujuan ?? '')" required
                            placeholder="Masukkan Nama Tujuan" />

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <x-back.button variant="light-brand" :href="route('admin.tujuan.index')">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Kembali</span>
                            </x-back.button>
                            <x-back.button type="submit">
                                <i class="feather-save me-2"></i>
                                <span>{{ isset($tujuan) ? 'Simpan Perubahan' : 'Simpan Tujuan' }}</span>
                            </x-back.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
