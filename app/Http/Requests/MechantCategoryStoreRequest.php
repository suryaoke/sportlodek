<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MechantCategoryStoreRequest extends FormRequest
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

                'unique:merchant_detail_categories,name,NULL,id,merchant_detail_id,' . $this->merchant_detail_id,
            ],
            'merchant_detail_id' => ['required', 'string', 'max:200'],
            'price' => ['required', 'integer'],
        ];
    }
}
