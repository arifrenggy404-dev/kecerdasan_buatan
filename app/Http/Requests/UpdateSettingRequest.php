<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'active_days' => 'required|array',
            'active_days.*' => 'integer|min:1|max:7',
            'operational_start' => 'required|date_format:H:i',
            'operational_end' => 'required|date_format:H:i|after:operational_start',
            
            'blackout_days' => 'nullable|array',
            'blackout_days.*' => 'integer|min:0|max:7',
            'blackout_starts' => 'nullable|array',
            'blackout_starts.*' => 'nullable|date_format:H:i',
            'blackout_ends' => 'nullable|array',
            'blackout_ends.*' => 'nullable|date_format:H:i',
            
            'sks_duration' => 'required|integer|min:10|max:120',
        ];
    }
}
