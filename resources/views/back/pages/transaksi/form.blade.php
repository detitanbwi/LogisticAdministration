@extends('back.layouts.app')

@section('title', isset($transaksi) ? 'Edit Transaksi' : 'Tambah Transaksi')

@section('page_title', isset($transaksi) ? 'Edit Transaksi' : 'Tambah Transaksi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.transaksi.index') }}">Transaksi</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ isset($transaksi) ? 'Edit' : 'Tambah' }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ isset($transaksi) ? route('admin.transaksi.update', $transaksi->id) : route('admin.transaksi.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($transaksi))
                            @method('PUT')
                        @endif

                        <x-back.text-input name="tanggal" type="date" label="Tanggal" :value="isset($transaksi) ? $transaksi->tanggal : old('tanggal', date('Y-m-d'))" required />

                        <x-back.select2 name="jenis" label="Jenis" :options="['pemasukan' => 'Pemasukan', 'pengeluaran' => 'Pengeluaran']" :selected="isset($transaksi) ? $transaksi->jenis : old('jenis')" required
                            id="jenisSelect" />

                        <div class="mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="transaksi_kategori_id" id="kategoriSelect" class="form-select form-control"
                                required>
                                <option value="">- Pilih -</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        {{ (isset($transaksi) && $transaksi->transaksi_kategori_id == $kategori->id) || old('transaksi_kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('transaksi_kategori_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nominal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control {{ $errors->has('nominal') ? 'is-invalid' : '' }}"
                                id="nominal_display" oninput="formatAndSetNominal(this)"
                                value="{{ isset($transaksi) && $transaksi->nominal ? number_format($transaksi->nominal, 0, ',', '.') : old('nominal_display') }}"
                                placeholder="0" required>
                            <input type="hidden" name="nominal" id="nominal_hidden"
                                value="{{ isset($transaksi) ? $transaksi->nominal : old('nominal') }}">
                            @error('nominal')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <x-back.textarea name="keterangan" label="Keterangan"
                            rows="3">{{ isset($transaksi) ? $transaksi->keterangan : old('keterangan') }}</x-back.textarea>

                        <x-back.select2 name="bank_rekening_id" label="Rekening Bank" :options="$rekenings
                            ->mapWithKeys(function ($item) {
                                return [
                                    $item->id =>
                                        $item->nama_bank .
                                        ' - ' .
                                        $item->no_rekening .
                                        ' (' .
                                        $item->nama_pemilik .
                                        ')',
                                ];
                            })
                            ->toArray()" :selected="isset($transaksi) ? $transaksi->bank_rekening_id : old('bank_rekening_id')"
                            required />

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <x-back.button variant="light-brand" :href="route('admin.transaksi.index')">
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
        $(document).ready(function() {
            var kategoris = @json($kategoris);
            var initSelectedVal =
                '{{ isset($transaksi) ? $transaksi->transaksi_kategori_id : old('transaksi_kategori_id') }}';

            function filterKategori() {
                var selectedJenis = $('#jenisSelect').val();
                var $kategoriSelect = $('#kategoriSelect');
                var currentVal = $kategoriSelect.val() || initSelectedVal;

                $kategoriSelect.empty();
                $kategoriSelect.append(new Option('- Pilih -', ''));

                kategoris.forEach(function(kategori) {
                    if (!selectedJenis || kategori.kategori === selectedJenis) {
                        var isSelected = (kategori.id == currentVal);
                        var newOption = new Option(kategori.nama, kategori.id, false, isSelected);
                        $kategoriSelect.append(newOption);
                    }
                });
                $kategoriSelect.trigger('change.select2');
            }

            window.formatAndSetNominal = function(element) {
                let value = element.value;
                let clean = value.replace(/[^\d,]/g, '');
                let parts = clean.split(',');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                if (parts.length > 2) {
                    clean = parts[0] + ',' + parts.slice(1).join('');
                } else {
                    clean = parts.join(',');
                }
                element.value = clean;

                let dbValue = clean.replace(/\./g, '').replace(/,/g, '.');
                document.getElementById('nominal_hidden').value = dbValue ? parseFloat(dbValue) : '';
            };

            // Call to reformat initially if there is value
            var initialNominal = $('#nominal_display').val();
            if (initialNominal) {
                formatAndSetNominal(document.getElementById('nominal_display'));
            }

            // Initialize display
            filterKategori();

            // Listen for changes
            $('#jenisSelect').on('change', function() {
                filterKategori();
            });

            // Setup select2
            $('#kategoriSelect').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        });
    </script>
@endpush
