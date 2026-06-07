<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerbaruiPengaturanRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'hari_aktif' => 'required|array',
            'hari_aktif.*' => 'integer|min:1|max:7',
            'jam_operasional_mulai' => 'required|date_format:H:i',
            'jam_operasional_selesai' => 'required|date_format:H:i|after:jam_operasional_mulai',
            
            'jam_istirahat_hari' => 'nullable|array',
            'jam_istirahat_hari.*' => 'integer|min:0|max:7',
            'jam_istirahat_mulai' => 'nullable|array',
            'jam_istirahat_mulai.*' => 'nullable|date_format:H:i',
            'jam_istirahat_selesai' => 'nullable|array',
            'jam_istirahat_selesai.*' => 'nullable|date_format:H:i',
            
            'durasi_sks' => 'required|integer|min:10|max:120',
        ];
    }
}
