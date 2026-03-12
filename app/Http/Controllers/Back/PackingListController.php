<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\Kapal;
use App\Models\Tujuan;
use Illuminate\Http\Request;

class PackingListController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Container::with(['asal', 'tujuan'])->withCount('invoices');
            return datatables()->of($query)
                ->addIndexColumn()
                ->filterColumn('pelabuhan_asal', function ($query, $keyword) {
                    $query->whereHas('asal', function ($q) use ($keyword) {
                        $q->where('nama_tujuan', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('pelabuhan_tujuan', function ($query, $keyword) {
                    $query->whereHas('tujuan', function ($q) use ($keyword) {
                        $q->where('nama_tujuan', 'like', "%{$keyword}%");
                    });
                })
                ->addColumn('pelabuhan_asal', function ($row) {
                    return $row->asal ? $row->asal->nama_tujuan : '-';
                })
                ->addColumn('pelabuhan_tujuan', function ($row) {
                    return $row->tujuan ? $row->tujuan->nama_tujuan : '-';
                })
                ->addColumn('etd', function ($row) {
                    return $row->etd ? \Carbon\Carbon::parse($row->etd)->format('d-m-Y') : '-';
                })
                ->addColumn('jumlah_invoice', function ($row) {
                    return '<span class="badge bg-soft-info text-info">' . $row->invoices_count . ' Invoice</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="hstack gap-2 justify-content-end">';
                    if (auth()->user()->can('view.container') || auth()->user()->can('print.invoice')) {
                        $btn .= '<a href="' . route('admin.packing-list.print', $row->id) . '" class="avatar-text avatar-md bg-soft-primary text-primary" title="Print Rekap Container" target="_blank"><i class="feather feather-printer"></i></a>';
                    }
                    if (auth()->user()->can('view.container') || auth()->user()->can('print.invoice')) {
                        $btn .= '<a href="' . route('admin.packing-list.export', $row->id) . '" class="avatar-text avatar-md bg-soft-success text-success" title="Export Excel"><i class="feather feather-download"></i></a>';
                    }
                    if (auth()->user()->can('edit.container')) {
                        $btn .= '<a href="' . route('admin.packing-list.edit', $row->id) . '" class="avatar-text avatar-md bg-soft-warning text-warning" title="Edit"><i class="feather feather-edit-3"></i></a>';
                    }
                    if (auth()->user()->can('delete.container')) {
                        $btn .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-danger text-danger delete-btn" data-id="' . $row->id . '" title="Hapus"><i class="feather feather-trash-2"></i></a>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['jumlah_invoice', 'action'])
                ->make(true);
        }

        return view('back.pages.packing-list.index');
    }

    public function create()
    {
        $kapals = Kapal::all();
        $tujuans = Tujuan::all();
        return view('back.pages.packing-list.form', compact('kapals', 'tujuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_container' => 'required|string|max:255|unique:container,nomor_container',
            'kapal_id' => 'nullable|exists:kapal,id',
            'asal_id' => 'nullable|exists:tujuan,id',
            'tujuan_id' => 'nullable|exists:tujuan,id|different:asal_id',
            'etd' => 'nullable|date',
            'eta' => 'nullable|date|after_or_equal:etd',
            'metode' => 'nullable|in:FCL,LCL,Break Bulk',
            'tipe_kontainer' => 'nullable|in:20FT,40FT,40HC,45HC',
            'catatan_invoicing' => 'nullable|string',
        ]);

        $container = Container::create($request->all());

        if ($request->ajax()) {
            return response()->json($container);
        }

        return redirect()->route('admin.packing-list.index')->with('success', 'Data Packing List berhasil ditambahkan.');
    }

    public function edit(Container $container)
    {
        $kapals = Kapal::all();
        $tujuans = Tujuan::all();
        return view('back.pages.packing-list.form', compact('container', 'kapals', 'tujuans'));
    }

    public function update(Request $request, Container $container)
    {
        $request->validate([
            'nomor_container' => 'required|string|max:255|unique:container,nomor_container,' . $container->id,
            'kapal_id' => 'nullable|exists:kapal,id',
            'asal_id' => 'nullable|exists:tujuan,id',
            'tujuan_id' => 'nullable|exists:tujuan,id|different:asal_id',
            'etd' => 'nullable|date',
            'eta' => 'nullable|date|after_or_equal:etd',
            'metode' => 'nullable|in:FCL,LCL,Break Bulk',
            'tipe_kontainer' => 'nullable|in:20FT,40FT,40HC,45HC',
            'catatan_invoicing' => 'nullable|string',
        ]);

        $container->update($request->all());

        return redirect()->route('admin.packing-list.index')->with('success', 'Data Packing List berhasil diupdate.');
    }

    public function destroy(Container $container)
    {
        try {
            $container->delete();
            return response()->json(['success' => 'Data Container berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data. ' . $e->getMessage()], 500);
        }
    }

    public function print(Container $container)
    {
        $container->load(['kapal', 'asal', 'tujuan', 'invoices.pengirim', 'invoices.penerima', 'invoices.items', 'invoices.finance', 'invoices.tujuanDaerah']);
        return view('back.pages.packing-list.print', compact('container'));
    }

    public function export(Container $container)
    {
        $container->load(['kapal', 'asal', 'tujuan', 'invoices.pengirim', 'invoices.penerima', 'invoices.items', 'invoices.finance', 'invoices.tujuanDaerah']);
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\PackingListExport($container), 'PackingList_' . str_replace(['/', '\\'], '-', $container->nomor_container) . '.xlsx');
    }
}
