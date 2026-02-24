<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal' => ['required', 'date'],
            'jenis' => ['required', 'in:pemasukan,pengeluaran'],
            'transaksi_kategori_id' => ['required', 'exists:transaksi_kategoris,id'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'keterangan' => ['nullable', 'string'],
            'bank_rekening_id' => ['required', 'exists:bank_rekenings,id'],
        ];
    }
}
