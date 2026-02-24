<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTujuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_tujuan' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('tujuan', 'nama_tujuan')->ignore($this->tujuan)
            ],
        ];
    }
}
