<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'professor_id',
        'class_id',
        'salle_id',
        'day',
        'start_time',
        'end_time',
        'old_room'
    ];

    protected $casts = [
        'start_time' => 'string',
        'end_time' => 'string',
        'day' => 'string'
    ];

    protected static $days = [
        'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
    ];

    public function setDayAttribute($value)
    {
        if (in_array($value, self::$days)) {
            $this->attributes['day'] = $value;
        } else {
            throw new \InvalidArgumentException('Invalid day value. Must be one of: ' . implode(', ', self::$days));
        }
    }

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class, 'salle_id');
    }
}
