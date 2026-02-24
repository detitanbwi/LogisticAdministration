<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
        return [
            'no_invoice' => 'required|string|unique:invoice,no_invoice,' . $this->invoice->id,
            'pengirim_id' => 'required|exists:customer,id',
            'penerima_id' => 'required|exists:customer,id',
            'up' => 'nullable|string|max:255',
            'tgl_masuk' => 'nullable|date',
            'container_id' => 'nullable|exists:container,id',
            'metode' => 'nullable|in:FCL,LCL,Break Bulk',
            'layanan' => 'required|in:Door to Door,CY to CY,CY to Door,Door to CY,Port to Port',
            'status_pembayaran' => 'nullable|in:Serahkan,Tahan',
            'pkp_status' => 'required|in:PKP,Non PKP',
            'catatan_muntahan' => 'nullable|string',

            'items' => 'required|array|min:1',
            'items.*.jenis_barang' => 'required|string',
            'items.*.koli' => 'required|integer|min:1',
            'items.*.jumlah' => 'required|numeric|min:0',
            'items.*.satuan' => 'required|in:M3,Kg,Unit',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ];
    }
}
