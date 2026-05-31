<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lecturer extends Model
{
    protected $fillable = ['name'];

    public function offerings(): HasMany
    {
        return $this->hasMany(CourseOffering::class);
    }
}
