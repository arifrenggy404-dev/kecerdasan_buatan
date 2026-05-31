<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuildingRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $id = $this->route('building') instanceof \App\Models\Building ? $this->route('building')->id : $this->route('building');

        return [
            'name' => 'required|string|max:255|unique:buildings,name,' . ($id ?? 'NULL'),
        ];
    }
}
