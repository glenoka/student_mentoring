<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teachers extends Model
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

    public function mentoringSessions()
    {
        return $this->hasMany(mentoring_session::class);
    }

    public function comments()
    {
        return $this->hasMany(mentoring_comments::class);
    }
}
