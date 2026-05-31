<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLecturerRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $id = $this->route('lecturer') instanceof \App\Models\Lecturer ? $this->route('lecturer')->id : $this->route('lecturer');

        return [
            'name' => 'required|string|max:255',
        ];
    }
}
