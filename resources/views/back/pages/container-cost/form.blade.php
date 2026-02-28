@extends('back.layouts.app')

@section('title', isset($container) ? 'Edit Container Cost' : 'Tambah Container Cost')

@section('page_title', isset($container) ? 'Edit Container Cost' : 'Tambah Container Cost')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.container-cost.index') }}">Container Cost</a></li>
    <li class="breadcrumb-item active">{{ isset($container) ? 'Edit' : 'Tambah' }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ isset($container) ? 'Edit Container Cost' : 'Tambah Container Cost' }}</h5>
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($container) ? route('admin.container-cost.update', $container->id) : route('admin.container-cost.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($container))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-back.text-input name="nomor_container" label="Nomor Container / Seal" :value="old('nomor_container', $container->nomor_container ?? '')" required
                                    placeholder="Masukkan Nomor Container / Seal" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-back.select2 label="Kapal" name="kapal_id" :options="$kapals->pluck('nama_kapal', 'id')->toArray()" :selected="old('kapal_id', $container->kapal_id ?? null)" required placeholder="Pilih Kapal" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-back.select2 label="Lokasi Asal" name="asal_id" :options="$tujuans->pluck('nama_tujuan', 'id')->toArray()" :selected="old('asal_id', $container->asal_id ?? null)" required placeholder="Pilih Asal" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-back.select2 label="Lokasi Tujuan" name="tujuan_id" :options="$tujuans->pluck('nama_tujuan', 'id')->toArray()" :selected="old('tujuan_id', $container->tujuan_id ?? null)" required placeholder="Pilih Tujuan" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-back.text-input type="date" label="ETD (Estimasi Berangkat)" name="etd"
                                    :value="old('etd', isset($container) && $container->etd ? $container->etd->format('Y-m-d') : '')" required />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-back.text-input type="date" label="ETA (Estimasi Tiba)" name="eta"
                                    :value="old('eta', isset($container) && $container->eta ? $container->eta->format('Y-m-d') : '')" required />
                            </div>


                            <div class="col-md-6 mb-3">
                                <x-back.select2 label="Tipe Kontainer" name="tipe_kontainer" :options="['20FT' => '20FT', '40FT' => '40FT', '40HC' => '40HC', '45HC' => '45HC']"
                                    :selected="old('tipe_kontainer', $container->tipe_kontainer ?? '20FT')" required />
                            </div>

                            <div class="col-md-12 mb-3">
                                <x-back.textarea label="Catatan Finance" name="catatan_finance" rows="3"
                                    placeholder="Contoh: Invoice Finance..." :value="old('catatan_finance', $container->catatan_finance ?? null)" />
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <x-back.button variant="light-brand" href="{{ route('admin.container-cost.index') }}">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Kembali</span>
                            </x-back.button>
                            <x-back.button type="submit">
                                <i class="feather-save me-2"></i>
                                <span>{{ isset($container) ? 'Simpan Perubahan' : 'Simpan Container Cost' }}</span>
                            </x-back.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
