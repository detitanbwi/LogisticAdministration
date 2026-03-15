<?php

namespace App\Http\Requests\Back;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255', Rule::unique('customer', 'nama')->ignore($this->customer)],
            'no_hp' => ['required', 'string', 'max:20', Rule::unique('customer', 'no_hp')->ignore($this->customer)],
            'npwp' => ['nullable', 'string', 'max:255'],
            'pic' => ['nullable', 'string', 'max:255'],
            'jabatan_pic' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
