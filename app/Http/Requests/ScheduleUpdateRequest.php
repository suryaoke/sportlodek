<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleUpdateRequest extends FormRequest
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
        $scheduleId = $this->input('id');
        $categori  = $this->input('merchant_detail_category_id');

        return [
            'id'          => ['required', 'integer', 'exists:schedules,id'],
            'merchant_detail_category_id' => ['required', 'integer', 'exists:merchant_detail_categories,id'],


            'name' => ['required', 'string', 'max:200'],
            'date' => ['required', 'string', 'max:200',
                'unique:schedules,date,' . $scheduleId . ',id,merchant_detail_category_id,' . $categori ,
        ],
        ];
    }
}
