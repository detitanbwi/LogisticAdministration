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
                                <x-back.select2 label="Kapal" name="kapal_id" :options="$kapals->pluck('nama_kapal', 'id')->toArray()" :selected="old('kapal_id', $container->kapal_id ?? null)" required placeholder="Pilih Kapal" :createOptionUrl="route('admin.kapal.index')" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-back.select2 label="Pelabuhan Asal" name="asal_id" :options="$tujuans->pluck('nama_tujuan', 'id')->toArray()" :selected="old('asal_id', $container->asal_id ?? null)" required placeholder="Pilih Asal" :createOptionUrl="route('admin.tujuan.index')" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-back.select2 label="Pelabuhan Tujuan" name="tujuan_id" :options="$tujuans->pluck('nama_tujuan', 'id')->toArray()" :selected="old('tujuan_id', $container->tujuan_id ?? null)" required placeholder="Pilih Tujuan" :createOptionUrl="route('admin.tujuan.index')" />
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


                            <hr class="my-4">
                            <div class="col-md-12 mb-4">
                                <h5 class="card-title">Rincian Biaya Operasional</h5>
                                <p class="text-muted small">Data Pengeluaran & Profit Container</p>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <x-back.text-input type="number" label="Total Pembayaran (Entry Manual)" name="total_pembayaran_manual" :value="old('total_pembayaran_manual', $container->total_pembayaran_manual ?? 0)" step="0.01" placeholder="0" />
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="operationalCostsTable">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Komponen Biaya</th>
                                                <th>Nominal (Rp)</th>
                                                <th>Tanggal Transfer</th>
                                                <th style="width: 50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $costs = (isset($container) ? $container->operationalCosts : collect([])) ?? collect([]);
                                            @endphp
                                            @foreach($costs as $cost)
                                            <tr>
                                                <td>
                                                    <input type="text" name="op_komponen[]" class="form-control" value="{{ $cost->komponen }}" placeholder="Contoh: Biaya BL CY-Port">
                                                </td>
                                                <td>
                                                    <input type="number" name="op_nominal[]" class="form-control" value="{{ $cost->nominal }}" step="0.01">
                                                </td>
                                                <td>
                                                    <input type="date" name="op_tgl[]" class="form-control" value="{{ $cost->tanggal_transfer ? $cost->tanggal_transfer->format('Y-m-d') : '' }}">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-row"><i class="feather-trash-2"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr class="add-row-placeholder">
                                                <td colspan="4" class="text-center py-3">
                                                    <button type="button" class="btn btn-primary btn-sm px-3" id="addRow">
                                                        <i class="feather-plus me-1"></i> Tambah Komponen Biaya
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <x-back.textarea label="Catatan Finance" name="catatan_finance" rows="10"
                                    placeholder="Contoh: Invoice Finance..." :value="old('catatan_finance', $container->catatan_finance ?? null)" />
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const tableBody = document.querySelector('#operationalCostsTable tbody');
                                const addRowBtn = document.getElementById('addRow');
                                const placeholder = document.querySelector('.add-row-placeholder');

                                addRowBtn.addEventListener('click', function() {
                                    const newRow = document.createElement('tr');
                                    newRow.innerHTML = `
                                        <td>
                                            <input type="text" name="op_komponen[]" class="form-control" placeholder="Contoh: Biaya BL CY-Port">
                                        </td>
                                        <td>
                                            <input type="number" name="op_nominal[]" class="form-control" value="0" step="0.01">
                                        </td>
                                        <td>
                                            <input type="date" name="op_tgl[]" class="form-control">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row"><i class="feather-trash-2"></i></button>
                                        </td>
                                    `;
                                    tableBody.insertBefore(newRow, placeholder);
                                });

                                tableBody.addEventListener('click', function(e) {
                                    if (e.target.closest('.remove-row')) {
                                        e.target.closest('tr').remove();
                                    }
                                });
                            });
                        </script>

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

