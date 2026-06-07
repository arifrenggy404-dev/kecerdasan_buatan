<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanMataKuliahRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        
        return [
            'mata_kuliah_id' => 'nullable|exists:mata_kuliah,id',
            'nama' => ($isUpdate ? 'sometimes|' : 'required_without:mata_kuliah_id|') . 'string|max:255',
            'kode' => 'nullable|string|max:50',
            'sks' => 'required|integer|min:1|max:6',
            'tipe' => 'required|in:teori,praktikum',
            'semester' => 'nullable|integer|min:1|max:8',
            'dosen_id' => ($isUpdate ? 'sometimes|' : 'required|') . 'exists:dosen,id',
            'ruangan_id' => 'nullable|exists:ruangan,id',
        ];
    }
}
