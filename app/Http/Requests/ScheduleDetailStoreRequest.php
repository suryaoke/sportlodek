<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleDetailStoreRequest extends FormRequest
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
            'in' => [
                'required',
                'string',
                'max:200',
                'unique:schedule_details,in,NULL,id,schedule_id,' . $this->schedule_id,
            ],
            'schedule_id' => ['required', 'string', 'max:200'],
            'out' => [
                'required',
                'string',
                'max:200',
                'unique:schedule_details,out,NULL,id,schedule_id,' . $this->schedule_id,
            ],
        ];
    }
}
