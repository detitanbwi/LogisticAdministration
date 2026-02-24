@extends('back.layouts.app')

@section('title', isset($bankRekening) ? 'Edit Rekening Bank' : 'Tambah Rekening Bank')

@section('page_title', isset($bankRekening) ? 'Edit Rekening Bank' : 'Tambah Rekening Bank')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.bank-rekening.index') }}">Rekening Bank</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ isset($bankRekening) ? 'Edit' : 'Tambah' }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ isset($bankRekening) ? route('admin.bank-rekening.update', $bankRekening->id) : route('admin.bank-rekening.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($bankRekening))
                            @method('PUT')
                        @endif

                        <x-back.select2 name="nama_bank" label="Nama Bank" :options="$bankOptions" :selected="isset($bankRekening) ? $bankRekening->nama_bank : old('nama_bank')" required />
                        <x-back.text-input name="no_rekening" label="Nomor Rekening" :value="isset($bankRekening) ? $bankRekening->no_rekening : old('no_rekening')" required />
                        <x-back.text-input name="nama_pemilik" label="Nama Pemilik" :value="isset($bankRekening) ? $bankRekening->nama_pemilik : old('nama_pemilik')" required />
                        <div class="mb-3">
                            <label class="form-label">Saldo Awal</label>
                            <input type="text" class="form-control {{ $errors->has('saldo') ? 'is-invalid' : '' }}"
                                id="saldo_display" oninput="formatAndSetNominal(this)"
                                value="{{ isset($bankRekening) && $bankRekening->saldo ? number_format($bankRekening->saldo, 0, ',', '.') : old('saldo_display', 0) }}"
                                placeholder="0" required>
                            <input type="hidden" name="saldo" id="saldo_hidden"
                                value="{{ isset($bankRekening) ? $bankRekening->saldo : old('saldo', 0) }}">
                            @error('saldo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <x-back.button variant="light-brand" :href="route('admin.bank-rekening.index')">
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

@push('scripts')
    <script>
        window.formatAndSetNominal = function(element) {
            let value = element.value;
            // Allow negative sign at start
            let clean = value.replace(/(?!^-)[^\d,]/g, '');

            let isNegative = clean.startsWith('-');
            if (isNegative) clean = clean.substring(1);

            let parts = clean.split(',');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            if (parts.length > 2) {
                clean = parts[0] + ',' + parts.slice(1).join('');
            } else {
                clean = parts.join(',');
            }

            clean = (isNegative ? '-' : '') + clean;
            element.value = clean;

            let dbValue = clean.replace(/\./g, '').replace(/,/g, '.');
            document.getElementById('saldo_hidden').value = dbValue ? parseFloat(dbValue) : '';
        };

        var initialSaldo = $('#saldo_display').val();
        if (initialSaldo) {
            formatAndSetNominal(document.getElementById('saldo_display'));
        }
    </script>
@endpush
