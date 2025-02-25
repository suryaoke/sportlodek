<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantStoreRequest extends FormRequest
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
            'image' => ['required', 'image', 'max:3000'],
            'name' => ['required', 'string', 'max:200', 'unique:merchants,name'],
            'user' => ['required', 'string', 'max:200'],
            'about' => ['required', 'string', 'max:200',],
            'address' => ['required', 'string', 'max:200',],
        ];
    }
}
