<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanDosenRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $id = $this->route('dosen') instanceof \App\Models\Dosen ? $this->route('dosen')->id : $this->route('dosen');

        return [
            'nama' => 'required|string|max:255',
        ];
    }
}
