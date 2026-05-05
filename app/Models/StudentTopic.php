<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StudentTopic extends Model
{
    use HasFactory;
    protected $table='student_topics';
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
        return $this->belongsTo(Student::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topics::class);
    }

    public function assessment()
    {
        return $this->belongsTo(Assessments::class);
    }

    public function mentoringSessions()
    {
        return $this->hasOne(MentoringSession::class, 'student_topic_id');
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
