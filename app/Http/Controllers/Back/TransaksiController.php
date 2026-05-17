<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\TransaksiKategori;
use App\Models\BankRekening;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\StoreTransaksiRequest;
use App\Http\Requests\Back\UpdateTransaksiRequest;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('view.transaksi'), 403);

        if ($request->ajax() && !$request->has('summary')) {
            $data = Transaksi::query()
                ->with(['kategori', 'rekening'])
                ->when($request->bank_rekening_id, function ($query) use ($request) {
                    $query->where('bank_rekening_id', $request->bank_rekening_id);
                })
                ->when($request->jenis, function ($query) use ($request) {
                    $query->where('jenis', $request->jenis);
                })
                ->when($request->transaksi_kategori_id, function ($query) use ($request) {
                    $query->where('transaksi_kategori_id', $request->transaksi_kategori_id);
                })
                ->when($request->daterange, function ($query) use ($request) {
                    $dates = explode(' - ', $request->daterange);
                    if (count($dates) == 2) {
                        $start = \Carbon\Carbon::parse($dates[0])->startOfDay();
                        $end = \Carbon\Carbon::parse($dates[1])->endOfDay();
                        $query->whereBetween('tanggal', [$start, $end]);
                    }
                })
                ->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($row) {
                    return \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d-M-Y');
                })
                ->editColumn('jenis', function ($row) {
                    $badge = $row->jenis == 'pemasukan' ? 'success' : 'danger';
                    return '<span class="badge bg-soft-' . $badge . ' text-' . $badge . '">' . ucfirst($row->jenis) . '</span>';
                })
                ->editColumn('nominal', function ($row) {
                    $prefix = $row->jenis == 'pemasukan' ? '+' : '-';
                    $color = $row->jenis == 'pemasukan' ? 'success' : 'danger';
                    return '<span class="text-' . $color . ' fw-bold">' . $prefix . ' Rp ' . number_format($row->nominal, 0, ',', '.') . '</span>';
                })
                ->addColumn('kategori', function ($row) {
                    return $row->kategori ? $row->kategori->nama : '-';
                })
                ->addColumn('rekening', function ($row) {
                    return $row->rekening ? $row->rekening->nama_bank . ' - ' . $row->rekening->no_rekening : '-';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.transaksi.edit', $row->id);
                    $btn = '<div class="hstack gap-2 justify-content-end">';

                    if (auth()->user()->can('edit.transaksi')) {
                        $btn .= '<a href="' . $editUrl . '" class="avatar-text avatar-md bg-soft-warning text-warning"><i class="feather feather-edit-3"></i></a>';
                    }

                    if (auth()->user()->can('delete.transaksi')) {
                        $btn .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-danger text-danger delete-btn" data-id="' . $row->id . '"><i class="feather feather-trash-2"></i></a>';
                    }

                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['jenis', 'action', 'nominal'])
                ->make(true);
        }

        $query = Transaksi::query()
            ->when($request->bank_rekening_id, function ($query) use ($request) {
                $query->where('bank_rekening_id', $request->bank_rekening_id);
            })
            ->when($request->jenis, function ($query) use ($request) {
                $query->where('jenis', $request->jenis);
            })
            ->when($request->transaksi_kategori_id, function ($query) use ($request) {
                $query->where('transaksi_kategori_id', $request->transaksi_kategori_id);
            })
            ->when($request->daterange, function ($query) use ($request) {
                $dates = explode(' - ', $request->daterange);
                if (count($dates) == 2) {
                    $start = \Carbon\Carbon::parse($dates[0])->startOfDay();
                    $end = \Carbon\Carbon::parse($dates[1])->endOfDay();
                    $query->whereBetween('tanggal', [$start, $end]);
                }
            });

        $total_pemasukan = (clone $query)->where('jenis', 'pemasukan')->sum('nominal');
        $total_pengeluaran = (clone $query)->where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $total_pemasukan - $total_pengeluaran;

        if ($request->ajax() && $request->has('summary')) {
            return response()->json([
                'total_pemasukan' => 'Rp ' . number_format($total_pemasukan, 0, ',', '.'),
                'total_pengeluaran' => 'Rp ' . number_format($total_pengeluaran, 0, ',', '.'),
                'saldo' => 'Rp ' . number_format($saldo, 0, ',', '.')
            ]);
        }

        $rekenings = BankRekening::all();
        $kategoris = TransaksiKategori::all();
        return view('back.pages.transaksi.index', compact('rekenings', 'kategoris', 'total_pemasukan', 'total_pengeluaran', 'saldo'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create.transaksi'), 403);
        $kategoris = TransaksiKategori::all();
        $rekenings = BankRekening::all();
        return view('back.pages.transaksi.form', compact('kategoris', 'rekenings'));
    }

    public function store(StoreTransaksiRequest $request)
    {
        abort_unless(auth()->user()->can('create.transaksi'), 403);

        $transaksi = Transaksi::create($request->validated());

        // Update Saldo (Optional but recommended logic)
        $rekening = BankRekening::find($transaksi->bank_rekening_id);
        if ($rekening) {
            if ($transaksi->jenis == 'pemasukan') {
                $rekening->saldo += $transaksi->nominal;
            } else {
                $rekening->saldo -= $transaksi->nominal;
            }
            $rekening->save();
        }

        if ($request->ajax()) {
            return response()->json($transaksi);
        }

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Transaksi $transaksi)
    {
        abort_unless(auth()->user()->can('edit.transaksi'), 403);
        $kategoris = TransaksiKategori::all();
        $rekenings = BankRekening::all();
        return view('back.pages.transaksi.form', compact('transaksi', 'kategoris', 'rekenings'));
    }

    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi)
    {
        abort_unless(auth()->user()->can('edit.transaksi'), 403);

        // Reverse old saldo
        $oldRekening = BankRekening::find($transaksi->bank_rekening_id);
        if ($oldRekening) {
            if ($transaksi->jenis == 'pemasukan') {
                $oldRekening->saldo -= $transaksi->nominal;
            } else {
                $oldRekening->saldo += $transaksi->nominal;
            }
            $oldRekening->save();
        }

        $transaksi->update($request->validated());

        // Apply new saldo
        $newRekening = BankRekening::find($transaksi->bank_rekening_id);
        if ($newRekening) {
            if ($transaksi->jenis == 'pemasukan') {
                $newRekening->saldo += $transaksi->nominal;
            } else {
                $newRekening->saldo -= $transaksi->nominal;
            }
            $newRekening->save();
        }

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        abort_unless(auth()->user()->can('delete.transaksi'), 403);

        // Reverse saldo before deleting
        $rekening = BankRekening::find($transaksi->bank_rekening_id);
        if ($rekening) {
            if ($transaksi->jenis == 'pemasukan') {
                $rekening->saldo -= $transaksi->nominal;
            } else {
                $rekening->saldo += $transaksi->nominal;
            }
            $rekening->save();
        }

        $transaksi->delete();
        return response()->json(['success' => 'Transaksi berhasil dihapus.']);
    }
}
