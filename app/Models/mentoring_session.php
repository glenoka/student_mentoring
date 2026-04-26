<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class mentoring_session extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_topic_id',
        'session_date',
        'notes',
        'status',
    ];

    protected $casts = [
        'session_date' => 'date',
    ];

  public function user()
{
    return $this->belongsTo(User::class);
}

    public function studentTopic()
    {
        return $this->belongsTo(student_topics::class);
    }

    public function comments()
    {
        return $this->hasMany(mentoring_comments::class);
    }

    protected static function booted(): void
{
    static::creating(function ($model) {
        if (!$model->uuid) {
            $model->uuid = Str::uuid();
        }
    });
}
public function getRouteKeyName(): string
{
    return 'uuid';
}
}
