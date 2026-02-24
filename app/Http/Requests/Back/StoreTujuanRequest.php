<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class StoreTujuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_tujuan' => ['required', 'string', 'max:255', 'unique:tujuan,nama_tujuan'],
        ];
    }
}
