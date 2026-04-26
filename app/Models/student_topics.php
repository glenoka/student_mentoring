<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class student_topics extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
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
        return $this->hasOne(mentoring_session::class, 'student_topic_id');
    }

     protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
    public function getRouteKeyName(): string
{
    return 'uuid';
}
}
