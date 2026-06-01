<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $fillable = [
        'course_offering_id',
        'room_id',
        'day_id',
        'start_time_slot_id',
        'batch_id',
    ];

    public function courseOffering(): BelongsTo
    {
        return $this->belongsTo(CourseOffering::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class);
    }

    public function startTimeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class, 'start_time_slot_id');
    }
}
