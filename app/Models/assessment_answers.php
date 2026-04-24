<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assessment_answers extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'question_id',
        'numeric_value',
        'boolean_value',
        'notes',
    ];

    protected $casts = [
        'boolean_value' => 'boolean',
    ];

    public function assessment()
    {
        return $this->belongsTo(assessments::class,);
    }

    public function question()
    {
        return $this->belongsTo(questions::class);
    }

    // Helper biar gampang ambil value
    public function getValueAttribute()
    {
        return $this->numeric_value ?? $this->boolean_value;
    }
}
