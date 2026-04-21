<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class questions extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'type',
        'category',
        'order_number',
        'is_active',
    ];
    public function answers()
    {
        return $this->hasMany(assessment_answers::class);
    }
}
