<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = ['kunci', 'nilai'];

    protected $casts = [
        'nilai' => 'array',
    ];

    /**
     * Mendapatkan nilai pengaturan berdasarkan kunci.
     */
    public static function getValue(string $kunci, $default = null)
    {
        $pengaturan = self::where('kunci', $kunci)->first();
        return $pengaturan ? $pengaturan->nilai : $default;
    }

    /**
     * Menyimpan nilai pengaturan berdasarkan kunci.
     */
    public static function setValue(string $kunci, $nilai)
    {
        return self::updateOrCreate(['kunci' => $kunci], ['nilai' => $nilai]);
    }
}
