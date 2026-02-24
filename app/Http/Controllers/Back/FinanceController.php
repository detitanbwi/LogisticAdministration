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
        abort_unless(auth()->user()->can('view.finance'), 403);

        if ($request->ajax()) {
            $query = Finance::with('invoice.pengirim', 'invoice.penerima')->select('finance.*');

            if ($request->filled('daterange')) {
                $dates = explode(' - ', $request->daterange);
                if (count($dates) == 2) {
                    $start_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                    $end_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('finance.created_at', [$start_date, $end_date]);
                }
            }

            if ($request->filled('status')) {
                $query->where('status_tagihan', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('no_invoice', function ($row) {
                    return $row->invoice ? $row->invoice->no_invoice : '-';
                })
                ->addColumn('total_tagihan', function ($row) {
                    return 'Rp ' . number_format($row->total_tagihan, 0, ',', '.');
                })
                ->editColumn('status_tagihan', function ($row) {
                    $color = $row->status_tagihan == 'Sudah ditagih' ? 'success' : 'danger';
                    return '<span class="badge bg-soft-' . $color . ' text-' . $color . '">' . $row->status_tagihan . '</span>';
                })
                ->addColumn('tgl_transfer', function ($row) {
                    if ($row->tgl_transfer) {
                        return '<span class="badge bg-soft-success text-success">' . \Carbon\Carbon::parse($row->tgl_transfer)->format('d-m-Y') . '</span>';
                    }
                    return '<span class="badge bg-soft-danger text-danger">Belum dibayar</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.finance.edit', $row->id);
                    $btn = '<div class="hstack gap-2 justify-content-end">';

                    if (auth()->user()->can('edit.finance')) {
                        $btn .= '<a href="' . $editUrl . '" class="avatar-text avatar-md bg-soft-primary text-primary" title="Update Finance"><i class="feather feather-edit"></i></a>';
                    }

                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['status_tagihan', 'tgl_transfer', 'action'])
                ->make(true);
        }

        return view('back.pages.finance.index');
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
            'tgl_transfer' => 'nullable|date',
            'catatan' => 'nullable|string',
            'terima_barang' => 'nullable|date',
            'bap_balik' => 'nullable|in:Sudah,Belum',
            'status_pembayaran' => 'nullable|in:Serahkan,Tahan',
        ]);

        $finance->update($request->only(['ditagih_ke', 'status_tagihan', 'tgl_transfer', 'catatan', 'bap_balik']));

        if ($finance->invoice) {
            $finance->invoice->update([
                'terima_barang' => $request->terima_barang,
                'status_pembayaran' => $request->status_pembayaran
            ]);
        }

        return redirect()->route('admin.finance.index')->with('success', 'Data finance berhasil diperbarui.');
    }
}
