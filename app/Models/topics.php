<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class topics extends Model
{
     use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'achievement',
        'strategy',
        'category',
    ];

    public function studentTopics()
    {
        return $this->hasMany(student_topics::class);
    }

    public function materials()
    {
        return $this->hasMany(materials::class);
    }
}
