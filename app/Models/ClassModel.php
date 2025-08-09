<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'classes';

    protected $fillable = [
        'name',
    ];

    public function students()
    {
        return $this->hasMany(User::class, 'class_id')->where('role', 'student');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }
}
