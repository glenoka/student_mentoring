<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class parents extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'name',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function students()
    {
        return $this->hasMany(students::class, 'parent_id');
    }

    public function comments()
    {
        return $this->hasMany(mentoring_comments::class, 'parent_id');
    }
}
