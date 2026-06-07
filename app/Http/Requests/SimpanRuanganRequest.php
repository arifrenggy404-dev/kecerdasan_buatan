<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanRuanganRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'gedung_id' => 'required|exists:gedung,id',
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:teori,praktikum',
        ];
    }
}
