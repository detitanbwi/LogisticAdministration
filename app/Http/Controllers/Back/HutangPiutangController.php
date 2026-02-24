<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\HutangPiutang;
use Illuminate\Http\Request;

class HutangPiutangController extends Controller
{
    public function hutang(Request $request)
    {
        abort_unless(auth()->user()->can('view.hutang'), 403);
        $type = 'Hutang';
        return $this->internalIndex($request, $type);
    }

    public function piutang(Request $request)
    {
        abort_unless(auth()->user()->can('view.piutang'), 403);
        $type = 'Piutang';
        return $this->internalIndex($request, $type);
    }

    private function internalIndex(Request $request, $type)
    {
        if ($request->ajax()) {
            $query = HutangPiutang::where('jenis', $type)->select('*');
            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('tanggal', function($row){
                    return \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y');
                })
                ->editColumn('nominal', function($row){
                    return number_format($row->nominal, 0, ',', '.');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="hstack gap-2 justify-content-end">';
                    
                    $perms = $row->jenis === 'Hutang' ? 'edit.hutang' : 'edit.piutang';
                    if (auth()->user()->can($perms)) {
                        $btn .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-warning text-warning edit-btn" data-id="'.$row->id.'" data-tanggal="'.$row->tanggal.'" data-nominal="'.$row->nominal.'" data-keterangan="'.$row->keterangan.'" title="Edit"><i class="feather feather-edit-3"></i></a>';
                    }
                    
                    $permsDel = $row->jenis === 'Hutang' ? 'delete.hutang' : 'delete.piutang';
                    if (auth()->user()->can($permsDel)) {
                        $btn .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-danger text-danger delete-btn" data-id="' . $row->id . '" title="Hapus"><i class="feather feather-trash-2"></i></a>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('back.pages.hutang_piutang.index', compact('type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Hutang,Piutang',
            'tanggal' => 'required|date',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $perms = $request->jenis === 'Hutang' ? 'create.hutang' : 'create.piutang';
        abort_unless(auth()->user()->can($perms), 403);

        // Generate kode e.g HTG-0001, PTG-0001
        $prefix = $request->jenis === 'Hutang' ? 'HTG' : 'PTG';
        $latest = HutangPiutang::where('jenis', $request->jenis)->latest('id')->first();
        $nextId = $latest ? $latest->id + 1 : 1;
        $kode = $prefix . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $params = $request->all();
        $params['kode'] = $kode;
        $item = HutangPiutang::create($params);

        if($request->ajax()) {
            return response()->json($item);
        }

        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $item = HutangPiutang::findOrFail($id);
        
        $perms = $item->jenis === 'Hutang' ? 'edit.hutang' : 'edit.piutang';
        abort_unless(auth()->user()->can($perms), 403);
        
        $item->update($request->only('tanggal','nominal','keterangan'));

        if($request->ajax()) {
            return response()->json($item);
        }

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = HutangPiutang::findOrFail($id);
        
        $perms = $item->jenis === 'Hutang' ? 'delete.hutang' : 'delete.piutang';
        abort_unless(auth()->user()->can($perms), 403);
        
        $item->delete();
        
        return response()->json(['success' => 'Data berhasil dihapus.']);
    }
}
