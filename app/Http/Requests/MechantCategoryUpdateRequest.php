<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MechantCategoryUpdateRequest extends FormRequest
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
        $merchantCategorilId = $this->input('id');
        $merchantDetailId = $this->input('merchant_detail_id');

        return [
            'id'          => ['required', 'integer', 'exists:merchant_detail_categories,id'],
            'merchant_detail_id' => ['required', 'integer', 'exists:merchant_details,id'],
            'name'        => [
                'required',
                'string',
                'max:200',
                // Unique berdasarkan merchant_id kecuali data dengan id yang sedang di-update
                'unique:merchant_detail_categories,name,' . $merchantCategorilId . ',id,merchant_detail_id,' . $merchantDetailId,
            ],

            'price' => ['required', 'integer'],
        ];
    }
}
