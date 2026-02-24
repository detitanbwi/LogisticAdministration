<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class StoreBankRekeningRequest extends FormRequest
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
            'nama_bank' => ['required', 'string', 'max:255'],
            'no_rekening' => ['required', 'string', 'max:255'],
            'nama_pemilik' => ['required', 'string', 'max:255'],
            'saldo' => ['nullable', 'numeric'],
        ];
    }
}
