<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    protected $table = 'dosen';

    protected $fillable = ['nama'];

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'dosen_id');
    }
}
