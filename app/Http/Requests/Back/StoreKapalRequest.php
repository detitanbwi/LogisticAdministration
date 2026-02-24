<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class StoreKapalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_kapal' => ['required', 'string', 'max:255', 'unique:kapal,nama_kapal'],
        ];
    }
}
