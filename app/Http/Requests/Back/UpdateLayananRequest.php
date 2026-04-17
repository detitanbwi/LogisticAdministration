<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLayananRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $layanan = $this->route('layanan');
        // Handle both ID string or Model instance from route model binding
        $id = is_object($layanan) ? $layanan->id : $layanan;

        return [
            'nama' => 'required|string|max:255|unique:layanans,nama,' . $id,
        ];
    }
}
