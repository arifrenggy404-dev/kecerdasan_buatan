<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ScheduleBatch extends Model
{
    use HasUuids;

    protected $fillable = ['id', 'name', 'fitness', 'generations', 'is_published'];

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'batch_id', 'id');
    }
}
