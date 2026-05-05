<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
  use SoftDeletes;

    protected $fillable=[
        'class',
        'name',
        'parent_id',
    ];
    public function parent()
    {
        return $this->belongsTo(Parents::class, 'parent_id');
    }

    public function assessments()
    {
        return $this->hasMany(Assessments::class);
    }

    public function studentTopics()
    {
        return $this->hasMany(StudentTopic::class);
    }
}
