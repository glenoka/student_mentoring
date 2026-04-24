<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class assessments extends Model
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
        return $this->belongsTo(students::class);
    }

    public function answers()
    {
        return $this->hasMany(assessment_answers::class, 'assessment_id');
    }

    public function studentTopics()
    {
        return $this->hasMany(student_topics::class);
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
