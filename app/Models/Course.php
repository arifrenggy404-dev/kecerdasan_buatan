<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = ['name', 'code', 'sks', 'type'];

    public function offerings(): HasMany
    {
        return $this->hasMany(CourseOffering::class);
    }
}
