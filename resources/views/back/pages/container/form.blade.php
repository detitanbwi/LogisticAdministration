@extends('back.layouts.app')

@section('title', isset($container) ? 'Edit Container' : 'Tambah Container')

@section('page_title', isset($container) ? 'Edit Container' : 'Tambah Container')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.container.index') }}">Container</a></li>
    <li class="breadcrumb-item active">{{ isset($container) ? 'Edit Container' : 'Tambah Container' }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ isset($container) ? 'Edit Container' : 'Tambah Container' }}</h5>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($container) ? route('admin.container.update', $container->id) : route('admin.container.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($container))
                            @method('PUT')
                        @endif

                        <x-back.text-input name="nomor_container" label="Nomor Container / Seal" :value="old('nomor_container', $container->nomor_container ?? '')" required
                            placeholder="Masukkan Nomor Container / Seal" />

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <x-back.button variant="light-brand" href="{{ route('admin.container.index') }}">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Kembali</span>
                            </x-back.button>
                            <x-back.button type="submit">
                                <i class="feather-save me-2"></i>
                                <span>{{ isset($container) ? 'Simpan Perubahan' : 'Simpan Container' }}</span>
                            </x-back.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
