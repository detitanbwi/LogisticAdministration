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
            'alamat' => ['nullable', 'string'],
        ];
    }
}
