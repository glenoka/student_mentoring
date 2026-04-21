<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_topics extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'topic_id',
        'assessment_id',
        'status',
        'notes',
    ];

    public function student()
    {
        return $this->belongsTo(students::class);
    }

    public function topic()
    {
        return $this->belongsTo(topics::class);
    }

    public function assessment()
    {
        return $this->belongsTo(assessments::class);
    }

    public function mentoringSessions()
    {
        return $this->hasMany(mentoring_sessions::class);
    }
}
