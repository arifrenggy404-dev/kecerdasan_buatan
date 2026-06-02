<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        
        return [
            'course_id' => 'nullable|exists:courses,id',
            'name' => ($isUpdate ? 'sometimes|' : 'required_without:course_id|') . 'string|max:255',
            'code' => 'nullable|string|max:50',
            'sks' => 'required|integer|min:1|max:6',
            'type' => 'required|in:theory,lab',
            'semester' => 'nullable|integer|min:1|max:8',
            'lecturer_id' => ($isUpdate ? 'sometimes|' : 'required|') . 'exists:lecturers,id',
            'room_id' => 'nullable|exists:rooms,id',
        ];
    }
}
