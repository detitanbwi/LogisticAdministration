@extends('back.layouts.app')

@section('title', 'Laporan')

@section('page_title', 'LAPORAN')
@section('page_subtitle', 'Data Laporan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Laporan</a></li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filter Laporan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.laporan.index') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Mulai Tanggal</label>
                                <input type="date" class="form-control" name="tanggal_dari" value="{{ $tanggal_dari }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Sampai Tanggal</label>
                                <input type="date" class="form-control" name="tanggal_sampai"
                                    value="{{ $tanggal_sampai }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori_id" class="form-select">
                                    <option value="semua">- Semua Kategori -</option>
                                    @foreach ($kategoris as $kat)
                                        <option value="{{ $kat->id }}"
                                            {{ $kategori_id == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="feather-filter me-1"></i> TAMPILKAN
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Laporan Pemasukan & Pengeluaran</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.laporan.print', ['tanggal_dari' => $tanggal_dari, 'tanggal_sampai' => $tanggal_sampai, 'kategori_id' => $kategori_id]) }}"
                            target="_blank" class="btn btn-success btn-sm">
                            <i class="feather-file-text me-1"></i> CETAK PDF
                        </a>
                        <a href="{{ route('admin.laporan.print', ['tanggal_dari' => $tanggal_dari, 'tanggal_sampai' => $tanggal_sampai, 'kategori_id' => $kategori_id]) }}"
                            target="_blank" class="btn btn-primary btn-sm">
                            <i class="feather-printer me-1"></i> PRINT
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <table class="table table-sm table-borderless mb-0" style="max-width: 400px;">
                            <tr>
                                <th style="width: 160px">DARI TANGGAL</th>
                                <td style="width: 10px">:</td>
                                <td>{{ $tanggal_dari }}</td>
                            </tr>
                            <tr>
                                <th>SAMPAI TANGGAL</th>
                                <td>:</td>
                                <td>{{ $tanggal_sampai }}</td>
                            </tr>
                            <tr>
                                <th>KATEGORI</th>
                                <td>:</td>
                                <td>{{ $kategori_id === 'semua' ? 'SEMUA KATEGORI' : $kategoris->firstWhere('id', $kategori_id)->nama ?? 'SEMUA KATEGORI' }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="width:100%">
                            <thead class="bg-light text-center align-middle">
                                <tr>
                                    <th rowspan="2" style="width: 5%">NO</th>
                                    <th rowspan="2">TANGGAL</th>
                                    <th rowspan="2">KATEGORI</th>
                                    <th rowspan="2">KETERANGAN</th>
                                    <th colspan="2">JENIS</th>
                                </tr>
                                <tr>
                                    <th>PEMASUKAN</th>
                                    <th>PENGELUARAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPemasukan = 0;
                                    $totalPengeluaran = 0;
                                @endphp
                                @forelse ($transaksis as $index => $row)
                                    @php
                                        if (strtolower($row->jenis) === 'pemasukan') {
                                            $totalPemasukan += $row->nominal;
                                        } else {
                                            $totalPengeluaran += $row->nominal;
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($row->tanggal)->format('Y/m/d') }}
                                        </td>
                                        <td>{{ $row->kategori->nama ?? '-' }}</td>
                                        <td>{{ $row->keterangan ?? '-' }}</td>
                                        <td class="text-end text-success font-monospace">
                                            {{ strtolower($row->jenis) === 'pemasukan' ? 'Rp ' . number_format($row->nominal, 0, ',', '.') . ',-' : '-' }}
                                        </td>
                                        <td class="text-end text-danger font-monospace">
                                            {{ strtolower($row->jenis) !== 'pemasukan' ? 'Rp ' . number_format($row->nominal, 0, ',', '.') . ',-' : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">Tidak ada catatan transaksi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="fw-bold">
                                <tr class="bg-light">
                                    <td colspan="4" class="text-end pe-4">TOTAL</td>
                                    <td class="text-end text-success font-monospace">Rp
                                        {{ number_format($totalPemasukan, 0, ',', '.') }},-</td>
                                    <td class="text-end text-danger font-monospace">Rp
                                        {{ number_format($totalPengeluaran, 0, ',', '.') }},-</td>
                                </tr>
                                @php $saldo = $totalPemasukan - $totalPengeluaran; @endphp
                                <tr class="bg-primary text-white">
                                    <td colspan="4" class="text-end pe-4" style="color:#fff">SALDO</td>
                                    <td colspan="2" class="text-center font-monospace" style="color:#fff">
                                        Rp {{ number_format($saldo, 0, ',', '.') }},-
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
