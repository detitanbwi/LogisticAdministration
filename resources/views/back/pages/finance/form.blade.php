@extends('back.layouts.app')

@section('title', 'Update Status Finance')
@section('page_title', 'Update Status Finance')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.finance.index') }}">Finance</a></li>
    <li class="breadcrumb-item active">Update Status</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Detail Invoice: {{ $finance->invoice->no_invoice }}</h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <p class="text-muted mb-1">Total Tagihan</p>
                            <h4 class="mb-0">Rp {{ number_format($finance->total_tagihan, 0, ',', '.') }}</h4>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1">Pengirim</p>
                            <h5 class="mb-0">{{ $finance->invoice->pengirim->nama ?? '-' }}</h5>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1">Penerima</p>
                            <h5 class="mb-0">{{ $finance->invoice->penerima->nama ?? '-' }}</h5>
                        </div>
                    </div>

                    <form action="{{ route('admin.finance.update', $finance->id) }}" method="POST" id="financeForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-back.select2 label="Status Tagihan" name="status_tagihan" :options="['Belum' => 'Belum', 'Sudah ditagih' => 'Sudah ditagih']" :selected="$finance->status_tagihan ?? 'Belum'"
                                    required />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-back.select2 label="Ditagih Ke" name="ditagih_ke" :options="['Penerima' => 'Penerima', 'Pengirim' => 'Pengirim']" :selected="$finance->ditagih_ke ?? 'Penerima'" required />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-back.text-input type="date" label="Tanggal Tagih" name="tanggal_tagih"
                                    :value="$finance->tanggal_tagih ? $finance->tanggal_tagih->format('Y-m-d') : ''" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-back.text-input type="date" label="Tanggal Transfer" name="tgl_transfer"
                                    :value="$finance->tgl_transfer ? $finance->tgl_transfer->format('Y-m-d') : ''" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-back.text-input type="date" label="Tanggal Terima Barang" name="terima_barang"
                                    :value="$finance->invoice && $finance->invoice->terima_barang
            ? $finance->invoice->terima_barang->format('Y-m-d')
            : ''" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-back.select2 label="BAP Balik" name="bap_balik" :options="['Sudah' => 'Sudah', 'Belum' => 'Belum']" :selected="$finance->bap_balik ?? 'Belum'" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-back.select2 label="Status Pembayaran (Ops)" name="status_pembayaran"
                                    :options="['Serahkan' => 'Serahkan', 'Tahan' => 'Tahan']"
                                    :selected="$finance->invoice->status_pembayaran ?? 'Tahan'" />
                            </div>

                            <div class="col-md-12 mb-3">
                                <x-back.textarea label="Catatan" name="catatan" :value="$finance->catatan" rows="3" />
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <x-back.button variant="secondary" :href="route('admin.finance.index')">Batal</x-back.button>
                            <x-back.button type="submit" variant="primary">Simpan Perubahan</x-back.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection