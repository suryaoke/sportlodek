<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantDetailUpdateRequest extends FormRequest
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
        // Pastikan mendapatkan ID dari merchant detail yang sedang di-update
        $merchantDetailId = $this->input('id');
        $merchantId = $this->input('merchant_id');

        return [
            'id'          => ['required', 'integer', 'exists:merchant_details,id'],
            'merchant_id' => ['required', 'integer', 'exists:merchants,id'],
            'name'        => [
                'required',
                'string',
                'max:200',
                // Unique berdasarkan merchant_id kecuali data dengan id yang sedang di-update
                'unique:merchant_details,name,' . $merchantDetailId . ',id,merchant_id,' . $merchantId,
            ],
            'desc'        => ['required', 'string', 'max:200'],
            'open'        => ['required', 'string', 'max:200'],
            'close'       => ['required', 'string', 'max:200'],
            'type'        => ['required', 'string', 'max:200'],
        ];
    }
}
