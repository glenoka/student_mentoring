<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class students extends Model
{
  use SoftDeletes;

    protected $fillable=[
        'class',
        'name',
        'parent_id',
    ];
    public function parent()
    {
        return $this->belongsTo(parents::class, 'parent_id');
    }

    public function assessments()
    {
        return $this->hasMany(assessments::class);
    }

    public function studentTopics()
    {
        return $this->hasMany(student_topics::class);
    }
}
