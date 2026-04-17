<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\StoreLayananRequest;
use App\Http\Requests\Back\UpdateLayananRequest;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('view.layanan'), 403);

        if ($request->ajax()) {
            $data = Layanan::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('admin.layanan.edit', $row->id);
                    $btn = '<div class="hstack gap-2 justify-content-end">';
                    
                    if (auth()->user()->can('edit.layanan')) {
                        $btn .= '<a href="'.$editUrl.'" class="avatar-text avatar-md bg-soft-warning text-warning"><i class="feather feather-edit-3"></i></a>';
                    }
                    
                    if (auth()->user()->can('delete.layanan')) {
                        $btn .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-danger text-danger delete-btn" data-id="'.$row->id.'"><i class="feather feather-trash-2"></i></a>';
                    }
                    
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('back.pages.layanan.index');
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create.layanan'), 403);
        return view('back.pages.layanan.form');
    }

    public function store(StoreLayananRequest $request)
    {
        abort_unless(auth()->user()->can('create.layanan'), 403);
        $layanan = Layanan::create($request->validated());
        
        if ($request->ajax()) {
            return response()->json($layanan);
        }
        
        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Layanan $layanan)
    {
        abort_unless(auth()->user()->can('edit.layanan'), 403);
        return view('back.pages.layanan.form', compact('layanan'));
    }

    public function update(UpdateLayananRequest $request, Layanan $layanan)
    {
        abort_unless(auth()->user()->can('edit.layanan'), 403);
        $layanan->update($request->validated());
        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        abort_unless(auth()->user()->can('delete.layanan'), 403);
        
        // Check if being used in any invoice
        if ($layanan->invoices()->exists()) {
            return response()->json(['error' => 'Layanan cannot be deleted as it is being used in one or more invoices.'], 422);
        }

        $layanan->delete();
        return response()->json(['success' => 'Layanan berhasil dihapus.']);
    }
}
