<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assessments extends Model
{
     use HasFactory;

    protected $fillable = [
        'student_id',
        'assessment_date',
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
        return $this->hasMany(assessment_answers::class);
    }

    public function studentTopics()
    {
        return $this->hasMany(student_topics::class);
    }
}
