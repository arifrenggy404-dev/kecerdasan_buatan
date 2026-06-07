<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanGedungRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $id = $this->route('gedung') instanceof \App\Models\Gedung ? $this->route('gedung')->id : $this->route('gedung');

        return [
            'nama' => 'required|string|max:255|unique:gedung,nama,' . ($id ?? 'NULL'),
        ];
    }
}
