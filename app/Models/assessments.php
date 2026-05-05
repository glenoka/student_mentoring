<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Assessments extends Model
{
     use HasFactory;

    protected $fillable = [
        'student_id',
        'assessment_date',
        'status',
    ];

    protected $casts = [
        'assessment_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function answers()
    {
        return $this->hasMany(AssessmentAnswer::class, 'assessment_id');
    }

    public function studentTopics()
    {
        return $this->hasMany(StudentTopic::class);
    }
    protected static function booted()
{
    static::creating(function ($model) {
        if (empty($model->uuid)) {
            $model->uuid = Str::uuid();
        }
    });
}
public function getRouteKeyName(): string
{
    return 'uuid';
}
}
