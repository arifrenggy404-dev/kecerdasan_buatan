<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'kelas_id',
        'ruangan_id',
        'hari_id',
        'slot_waktu_mulai_id',
        'id_batch',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function hari(): BelongsTo
    {
        return $this->belongsTo(Hari::class, 'hari_id');
    }

    public function slotWaktuMulai(): BelongsTo
    {
        return $this->belongsTo(SlotWaktu::class, 'slot_waktu_mulai_id');
    }
}
