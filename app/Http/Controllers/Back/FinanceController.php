<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('view_rekapitulasi.finance'), 403);

        if ($request->ajax()) {
            $query = Finance::with(['invoice.pengirim', 'invoice.penerima', 'invoice.items', 'invoice.additionalFees'])->select('finance.*');

            $query->whereHas('invoice.container', function ($q) use ($request) {
                if ($request->filled('asal_id')) {
                    $q->where('asal_id', $request->asal_id);
                }
                if ($request->filled('tujuan_id')) {
                    $q->where('tujuan_id', $request->tujuan_id);
                }
            });

            if ($request->filled('pengirim_id')) {
                $query->whereHas('invoice', function ($q) use ($request) {
                    $q->where('pengirim_id', $request->pengirim_id);
                });
            }

            if ($request->filled('penerima_id')) {
                $query->whereHas('invoice', function ($q) use ($request) {
                    $q->where('penerima_id', $request->penerima_id);
                });
            }

            if ($request->filled('daterange')) {
                $dates = explode(' - ', $request->daterange);
                if (count($dates) == 2) {
                    $start_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                    $end_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                    $query->whereHas('invoice.container', function ($q) use ($start_date, $end_date) {
                        $q->whereBetween('etd', [$start_date, $end_date]);
                    });
                }
            }

            if ($request->filled('status')) {
                if (in_array($request->status, ['Belum', 'Sudah ditagih'])) {
                    $query->where('status_tagihan', $request->status);
                } else if ($request->status == 'Belum Lunas') {
                    $query->whereNull('tgl_transfer');
                } else if ($request->status == 'Lunas') {
                    $query->whereNotNull('tgl_transfer');
                }
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->filterColumn('no_invoice', function ($query, $keyword) {
                    $query->whereHas('invoice', function ($q) use ($keyword) {
                        $q->where('no_invoice', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('pengirim', function ($query, $keyword) {
                    $query->whereHas('invoice.pengirim', function ($q) use ($keyword) {
                        $q->where('nama', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('penerima', function ($query, $keyword) {
                    $query->whereHas('invoice.penerima', function ($q) use ($keyword) {
                        $q->where('nama', 'like', "%{$keyword}%");
                    });
                })
                ->addColumn('no_invoice', function ($row) {
                    return $row->invoice ? $row->invoice->no_invoice : '-';
                })
                ->addColumn('pengirim', function ($row) {
                    return $row->invoice && $row->invoice->pengirim ? $row->invoice->pengirim->nama : '-';
                })
                ->addColumn('penerima', function ($row) {
                    return $row->invoice && $row->invoice->penerima ? $row->invoice->penerima->nama : '-';
                })
                ->addColumn('total_tagihan', function ($row) {
                    if (!$row->invoice) return '-';
                    $dpp_base = $row->invoice->items->sum(function($item) {
                        if (strtoupper($item->satuan) == 'UNIT') {
                            return $item->koli * $item->harga_satuan;
                        }
                        return $item->jumlah * $item->harga_satuan;
                    });
                    $fee_val = $row->invoice->additionalFees ? $row->invoice->additionalFees->sum('harga') : 0;
                    $total = $dpp_base + $fee_val;
                    if (strtoupper($row->invoice->pkp_status) == 'PKP') {
                        $total = round($total * 1.011);
                    }
                    return 'Rp ' . number_format($total, 0, ',', '.');
                })
                ->editColumn('status_tagihan', function ($row) {
                    $color = $row->status_tagihan == 'Sudah ditagih' ? 'success' : 'danger';
                    return '<span class="badge bg-soft-' . $color . ' text-' . $color . '">' . $row->status_tagihan . '</span>';
                })
                ->addColumn('tgl_transfer', function ($row) {
                    if ($row->tgl_transfer) {
                        return '<span class="badge bg-soft-success text-success">' . \Carbon\Carbon::parse($row->tgl_transfer)->format('d-M-Y') . '</span>';
                    }
                    return '<span class="badge bg-soft-danger text-danger">Belum dibayar</span>';
                })
                ->addColumn('tanggal_tagih', function ($row) {
                    return $row->tanggal_tagih ? \Carbon\Carbon::parse($row->tanggal_tagih)->format('d-M-Y') : '-';
                })
                ->addColumn('masa_tunggakan', function ($row) {
                    if (!$row->tanggal_tagih)
                        return '-';
                    if ($row->tgl_transfer)
                        return '<span class="badge bg-soft-success text-success">Lunas</span>';

                    $today = \Carbon\Carbon::now()->startOfDay();
                    $tagih = \Carbon\Carbon::parse($row->tanggal_tagih)->startOfDay();
                    $diffDays = $tagih->diffInDays($today, false);

                    if ($diffDays > 0) {
                        return '<span class="badge bg-soft-danger text-danger">' . intval($diffDays) . ' Hari</span>';
                    }
                    return '-';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.finance.edit', $row->id);
                    $btn = '<div class="hstack gap-2 justify-content-end">';

                    if (auth()->user()->can('edit.finance')) {
                        $btn .= '<a href="' . $editUrl . '" class="avatar-text avatar-md bg-soft-primary text-primary" title="Update Finance"><i class="feather feather-edit"></i></a>';
                    }

                    $btn .= '<a href="' . route('admin.finance.print', $row->id) . '" class="avatar-text avatar-md bg-soft-info text-info" target="_blank" title="Print Summary"><i class="feather feather-printer"></i></a>';

                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['status_tagihan', 'tgl_transfer', 'masa_tunggakan', 'action'])
                ->make(true);
        }

        $tujuans = \App\Models\Tujuan::all();
        $customers = \App\Models\Customer::all();
        $judulPrints = \App\Models\JudulPrint::all();
        return view('back.pages.finance.index', compact('tujuans', 'judulPrints', 'customers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Finance $finance)
    {
        abort_unless(auth()->user()->can('edit.finance'), 403);
        $finance->load('invoice');
        return view('back.pages.finance.form', compact('finance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Finance $finance)
    {
        abort_unless(auth()->user()->can('edit.finance'), 403);

        $validated = $request->validate([
            'ditagih_ke' => 'required|in:Pengirim,Penerima',
            'status_tagihan' => 'required|in:Sudah ditagih,Belum',
            'tanggal_tagih' => 'nullable|date',
            'tgl_transfer' => 'nullable|date',
            'catatan' => 'nullable|string',
            'terima_barang' => 'nullable|date',
            'bap_balik' => 'nullable|in:Sudah,Belum',
            'status_pembayaran' => 'nullable|in:Serahkan,Tahan',
        ]);

        $finance->update($request->only(['ditagih_ke', 'status_tagihan', 'tanggal_tagih', 'tgl_transfer', 'catatan', 'bap_balik']));

        if ($finance->invoice) {
            $finance->invoice->update([
                'terima_barang' => $request->terima_barang,
                'status_pembayaran' => $request->status_pembayaran
            ]);

            // Auto Insert to Transaksi
            if ($finance->tgl_transfer && $finance->total_tagihan > 0) {
                $rekening = \App\Models\BankRekening::firstOrCreate(
                    ['no_rekening' => '0000000000'],
                    ['nama_bank' => 'Kas / Bank Utama', 'nama_pemilik' => 'Perusahaan', 'saldo' => 0]
                );
                $kategori = \App\Models\TransaksiKategori::firstOrCreate(
                    ['nama' => 'Pemasukan Invoice'],
                    ['jenis' => 'pemasukan']
                );

                if ($rekening) {
                    $keterangan = 'Pembayaran Invoice ' . $finance->invoice->no_invoice;
                    $existingTransaksi = \App\Models\Transaksi::where('keterangan', $keterangan)->first();

                    if (!$existingTransaksi) {
                        \App\Models\Transaksi::create([
                            'tanggal' => $finance->tgl_transfer,
                            'jenis' => 'pemasukan',
                            'transaksi_kategori_id' => $kategori->id,
                            'nominal' => $finance->total_tagihan,
                            'keterangan' => $keterangan,
                            'bank_rekening_id' => $rekening->id
                        ]);

                        $rekening->saldo += $finance->total_tagihan;
                        $rekening->save();
                    } else {
                        // Update if exists
                        $diff = $finance->total_tagihan - $existingTransaksi->nominal;
                        $oldRekeningId = $existingTransaksi->bank_rekening_id;
                        $existingTransaksi->update([
                            'tanggal' => $finance->tgl_transfer,
                            'nominal' => $finance->total_tagihan,
                        ]);

                        if ($diff != 0 && $oldRekeningId == $rekening->id) {
                            $rekening->saldo += $diff;
                            $rekening->save();
                        }
                    }
                }
            }
        }

        return redirect()->route('admin.finance.index')->with('success', 'Data finance berhasil diperbarui.');
    }

    public function print(Finance $finance)
    {
        abort_unless(auth()->user()->can('view_rekapitulasi.finance') || auth()->user()->can('print.finance'), 403);

        $finance->load([
            'invoice.pengirim',
            'invoice.penerima',
            'invoice.items',
            'invoice.container.kapal',
            'invoice.container.asal',
            'invoice.container.tujuan',
            'invoice.additionalFees',
            'invoice.tujuanDaerah',
            'invoice.upDetail'
        ]);

        return view('back.pages.finance.print', compact('finance'));
    }

    public function export(Request $request)
    {
        abort_unless(auth()->user()->can('view_rekapitulasi.finance') || auth()->user()->can('print.finance'), 403);

        $query = Finance::with(['invoice.pengirim', 'invoice.penerima', 'invoice.items', 'invoice.container.kapal', 'invoice.container.asal', 'invoice.container.tujuan', 'invoice.additionalFees', 'invoice.tujuanDaerah'])->select('finance.*');

        $query->whereHas('invoice.container', function ($q) use ($request) {
            if ($request->filled('asal_id')) {
                $q->where('asal_id', $request->asal_id);
            }
            if ($request->filled('tujuan_id')) {
                $q->where('tujuan_id', $request->tujuan_id);
            }
        });

        if ($request->filled('pengirim_id')) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->where('pengirim_id', $request->pengirim_id);
            });
        }

        if ($request->filled('penerima_id')) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->where('penerima_id', $request->penerima_id);
            });
        }

        if ($request->filled('daterange')) {
            $dates = explode(' - ', $request->daterange);
            if (count($dates) == 2) {
                $start_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $end_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                $query->whereHas('invoice.container', function ($q) use ($start_date, $end_date) {
                    $q->whereBetween('etd', [$start_date, $end_date]);
                });
            }
        }

        if ($request->filled('status')) {
            if (in_array($request->status, ['Belum', 'Sudah ditagih'])) {
                $query->where('status_tagihan', $request->status);
            } else if ($request->status == 'Belum Lunas') {
                $query->whereNull('tgl_transfer');
            } else if ($request->status == 'Lunas') {
                $query->whereNotNull('tgl_transfer');
            }
        }

        if ($request->filled('search')) { // from datatables search
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('invoice', function ($inv) use ($keyword) {
                    $inv->where('no_invoice', 'like', "%{$keyword}%");
                })
                    ->orWhereHas('invoice.pengirim', function ($pg) use ($keyword) {
                        $pg->where('nama', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('invoice.penerima', function ($pn) use ($keyword) {
                        $pn->where('nama', 'like', "%{$keyword}%");
                    });
            });
        }

        $judulPrint = null;
        if ($request->filled('judul_print_id')) {
            $judulObj = \App\Models\JudulPrint::find($request->judul_print_id);
            if ($judulObj) {
                $judulPrint = $judulObj->nama;
            }
        }

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\FinanceRecapExport($query->get(), [
            'judul_print' => $judulPrint,
            'daterange' => $request->daterange
        ]), 'FinanceRekap_' . date('YmdHis') . '.xlsx');
    }
}
