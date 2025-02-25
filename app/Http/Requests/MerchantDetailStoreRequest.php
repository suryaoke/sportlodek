<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantDetailStoreRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:200',
                // Menggunakan rule unique dengan where clause agar unique berdasarkan merchant_id
                'unique:merchant_details,name,NULL,id,merchant_id,' . $this->merchant_id,
            ],
            'merchant_id' => ['required', 'string', 'max:200'],
            'desc' => ['required', 'string', 'max:200'],
            'open' => ['required', 'string', 'max:200'],
            'close' => ['required', 'string', 'max:200'],
            'type' => ['required', 'string', 'max:200'],
        ];
    }
}
