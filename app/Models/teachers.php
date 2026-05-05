<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teachers extends Model
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
        return $this->hasMany(MentoringSession::class);
    }

    public function comments()
    {
        return $this->hasMany(MentoringComment::class);
    }
}
