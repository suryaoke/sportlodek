<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleDetailUpdateRequest extends FormRequest
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
        $scheduleDetailId = $this->input('id');
        $schedule  = $this->input('schedule_id');

        return [
            'id'          => ['required', 'integer', 'exists:schedule_details,id'],
            'schedule_id' => ['required', 'integer', 'exists:schedules,id'],


            'in' => [
                'required',
                'string',
                'max:200',
                'unique:schedule_details,in,' . $scheduleDetailId . ',id,schedule_id,' . $schedule,
            ],
            'out' => [
                'required',
                'string',
                'max:200',
                'unique:schedule_details,out,' . $scheduleDetailId . ',id,schedule_id,' . $schedule,
            ]
        ];
    }
}
