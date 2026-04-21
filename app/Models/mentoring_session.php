<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mentoring_session extends Model
{
    use HasFasctory;

    protected $fillable = [
        'teacher_id',
        'student_topic_id',
        'session_date',
        'notes',
        'status',
    ];

    protected $casts = [
        'session_date' => 'date',
    ];

    public function teacher()
    {
        return $this->belongsTo(teachers::class);
    }

    public function studentTopic()
    {
        return $this->belongsTo(student_topics::class);
    }

    public function comments()
    {
        return $this->hasMany(mentoring_commentssd::class);
    }
}
