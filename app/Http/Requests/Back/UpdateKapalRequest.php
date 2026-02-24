<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKapalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_kapal' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('kapal', 'nama_kapal')->ignore($this->kapal)
            ],
        ];
    }
}
