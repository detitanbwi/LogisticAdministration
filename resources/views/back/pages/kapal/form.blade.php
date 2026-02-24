@extends('back.layouts.app')

@section('title', isset($kapal) ? 'Edit Kapal' : 'Tambah Kapal')

@section('page_title', isset($kapal) ? 'Edit Kapal' : 'Tambah Kapal')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.kapal.index') }}">Kapal</a></li>
    <li class="breadcrumb-item active">{{ isset($kapal) ? 'Edit Kapal' : 'Tambah Kapal' }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ isset($kapal) ? 'Edit Kapal' : 'Tambah Kapal' }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($kapal) ? route('admin.kapal.update', $kapal->id) : route('admin.kapal.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($kapal))
                            @method('PUT')
                        @endif

                        <x-back.text-input name="nama_kapal" label="Nama Kapal" :value="old('nama_kapal', $kapal->nama_kapal ?? '')" required
                            placeholder="Masukkan Nama Kapal" />

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <x-back.button variant="light-brand" :href="route('admin.kapal.index')">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Kembali</span>
                            </x-back.button>
                            <x-back.button type="submit">
                                <i class="feather-save me-2"></i>
                                <span>{{ isset($kapal) ? 'Simpan Perubahan' : 'Simpan Kapal' }}</span>
                            </x-back.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
