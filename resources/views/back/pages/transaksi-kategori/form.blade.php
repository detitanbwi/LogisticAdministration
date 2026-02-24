@extends('back.layouts.app')

@section('title', isset($transaksiKategori) ? 'Edit Kategori Transaksi' : 'Tambah Kategori Transaksi')

@section('page_title', isset($transaksiKategori) ? 'Edit Kategori Transaksi' : 'Tambah Kategori Transaksi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.transaksi-kategori.index') }}">Kategori Transaksi</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ isset($transaksiKategori) ? 'Edit' : 'Tambah' }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ isset($transaksiKategori) ? route('admin.transaksi-kategori.update', $transaksiKategori->id) : route('admin.transaksi-kategori.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($transaksiKategori))
                            @method('PUT')
                        @endif

                        <x-back.text-input name="nama" label="Nama Kategori" :value="isset($transaksiKategori) ? $transaksiKategori->nama : old('nama')" required />

                        <x-back.select2 name="kategori" label="Tipe Kategori" :options="['pemasukan' => 'Pemasukan', 'pengeluaran' => 'Pengeluaran']" :selected="isset($transaksiKategori) ? $transaksiKategori->kategori : old('kategori')"
                            required />

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <x-back.button variant="light-brand" :href="route('admin.transaksi-kategori.index')">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Kembali</span>
                            </x-back.button>
                            <x-back.button type="submit">
                                <i class="feather-save me-2"></i>
                                <span>Simpan</span>
                            </x-back.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
