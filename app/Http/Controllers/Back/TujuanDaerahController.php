<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\TujuanDaerah;
use Illuminate\Http\Request;

class TujuanDaerahController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:tujuan_daerah,nama',
        ]);

        $tujuanDaerah = TujuanDaerah::create($request->only('nama'));

        if ($request->ajax()) {
            return response()->json($tujuanDaerah);
        }

        return back()->with('success', 'Tujuan Daerah berhasil ditambahkan.');
    }
}
