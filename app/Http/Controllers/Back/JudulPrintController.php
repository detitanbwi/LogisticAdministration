<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\JudulPrint;
use Illuminate\Http\Request;

class JudulPrintController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JudulPrint::orderBy('id', 'desc')->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex gap-2 justify-content-end">';
                    $btn .= '<button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal' . $row->id . '"><i class="feather-edit"></i></button>';
                    $btn .= '<button type="button" class="btn btn-sm btn-icon btn-outline-danger delete-btn" data-id="' . $row->id . '"><i class="feather-trash-2"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('back.pages.judul_print.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:judul_prints,nama'
        ]);

        $judulPrint = JudulPrint::create(['nama' => $request->nama]);

        if ($request->ajax()) {
            return response()->json($judulPrint);
        }

        return redirect()->back()->with('success', 'Judul Print berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:judul_prints,nama,' . $id
        ]);

        $judulPrint = JudulPrint::findOrFail($id);
        $judulPrint->update(['nama' => $request->nama]);

        return redirect()->back()->with('success', 'Judul Print berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $judulPrint = JudulPrint::findOrFail($id);
        $judulPrint->delete();

        return response()->json(['success' => 'Judul Print berhasil dihapus.']);
    }
}
