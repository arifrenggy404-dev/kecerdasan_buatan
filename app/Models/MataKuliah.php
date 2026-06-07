<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';

    protected $fillable = ['nama', 'kode', 'sks', 'tipe', 'semester'];

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'mata_kuliah_id');
    }
}
