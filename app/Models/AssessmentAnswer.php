<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class AssessmentAnswer extends Model
{
    use HasFactory;
    protected $table='assessment_answers';
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
        return $this->belongsTo(Assessments::class,);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Helper biar gampang ambil value
    public function getValueAttribute()
    {
        return $this->numeric_value ?? $this->boolean_value;
    }
}
