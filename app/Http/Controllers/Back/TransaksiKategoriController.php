<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\TransaksiKategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\StoreTransaksiKategoriRequest;
use App\Http\Requests\Back\UpdateTransaksiKategoriRequest;

class TransaksiKategoriController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('view.kategori_keuangan'), 403);

        if ($request->ajax()) {
            $data = TransaksiKategori::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('admin.transaksi-kategori.edit', $row->id);
                    $btn = '<div class="hstack gap-2 justify-content-end">';
                    
                    if (auth()->user()->can('edit.kategori_keuangan')) {
                        $btn .= '<a href="'.$editUrl.'" class="avatar-text avatar-md bg-soft-warning text-warning"><i class="feather feather-edit-3"></i></a>';
                    }
                    
                    if (auth()->user()->can('delete.kategori_keuangan')) {
                        $btn .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-danger text-danger delete-btn" data-id="'.$row->id.'"><i class="feather feather-trash-2"></i></a>';
                    }
                    
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('back.pages.transaksi-kategori.index');
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create.kategori_keuangan'), 403);
        return view('back.pages.transaksi-kategori.form');
    }

    public function store(StoreTransaksiKategoriRequest $request)
    {
        abort_unless(auth()->user()->can('create.kategori_keuangan'), 403);
        $kategori = TransaksiKategori::create($request->validated());
        
        if ($request->ajax()) {
            return response()->json($kategori);
        }
        
        return redirect()->route('admin.transaksi-kategori.index')->with('success', 'Kategori Transaksi berhasil ditambahkan.');
    }

    public function edit(TransaksiKategori $transaksiKategori)
    {
        abort_unless(auth()->user()->can('edit.kategori_keuangan'), 403);
        return view('back.pages.transaksi-kategori.form', compact('transaksiKategori'));
    }

    public function update(UpdateTransaksiKategoriRequest $request, TransaksiKategori $transaksiKategori)
    {
        abort_unless(auth()->user()->can('edit.kategori_keuangan'), 403);
        $transaksiKategori->update($request->validated());
        return redirect()->route('admin.transaksi-kategori.index')->with('success', 'Kategori Transaksi berhasil diperbarui.');
    }

    public function destroy(TransaksiKategori $transaksiKategori)
    {
        abort_unless(auth()->user()->can('delete.kategori_keuangan'), 403);
        $transaksiKategori->delete();
        return response()->json(['success' => 'Kategori Transaksi berhasil dihapus.']);
    }
}
