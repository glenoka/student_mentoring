<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table='questions';
    protected $fillable = [
        'question_text',
        'type',
        'category',
        'order_number',
        'image',
        'is_active',
    ];
    public function answers()
    {
        return $this->hasMany(AssessmentAnswer::class);
    }
}
