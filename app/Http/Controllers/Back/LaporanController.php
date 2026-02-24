<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiKategori;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Default filter logic
        $tanggal_dari = $request->input('tanggal_dari', date('Y-m-01'));
        $tanggal_sampai = $request->input('tanggal_sampai', date('Y-m-d'));
        $kategori_id = $request->input('kategori_id', 'semua');

        $query = Transaksi::with(['kategori']);

        if ($tanggal_dari && $tanggal_sampai) {
            $from = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal_dari)));
            $to = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal_sampai)));
            $query->whereBetween('tanggal', [$from, $to]);
        }

        if ($kategori_id !== 'semua') {
            $query->where('transaksi_kategori_id', $kategori_id);
        }

        $transaksis = $query->orderBy('tanggal', 'asc')->get();

        $kategoris = TransaksiKategori::all();

        return view('back.pages.laporan.index', compact(
            'transaksis', 'kategoris', 'tanggal_dari', 'tanggal_sampai', 'kategori_id'
        ));
    }

    public function print(Request $request)
    {
        $tanggal_dari = $request->input('tanggal_dari', date('Y-m-01'));
        $tanggal_sampai = $request->input('tanggal_sampai', date('Y-m-d'));
        $kategori_id = $request->input('kategori_id', 'semua');

        $query = Transaksi::with(['kategori']);

        if ($tanggal_dari && $tanggal_sampai) {
            $from = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal_dari)));
            $to = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal_sampai)));
            $query->whereBetween('tanggal', [$from, $to]);
        }

        if ($kategori_id !== 'semua') {
            $query->where('transaksi_kategori_id', $kategori_id);
        }

        $transaksis = $query->orderBy('tanggal', 'asc')->get();
        $detailKategori = $kategori_id === 'semua' ? 'SEMUA KATEGORI' : TransaksiKategori::find($kategori_id)->nama ?? 'SEMUA KATEGORI';

        return view('back.pages.laporan.print', compact(
            'transaksis', 'tanggal_dari', 'tanggal_sampai', 'kategori_id', 'detailKategori'
        ));
    }
}
