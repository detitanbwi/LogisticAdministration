<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransaksiKategoriRequest extends FormRequest
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
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:pemasukan,pengeluaran'],
        ];
    }
}
