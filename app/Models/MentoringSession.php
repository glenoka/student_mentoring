<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MentoringSession extends Model
{
    use HasFactory;

    //protected $table='mentoring_sessions';
    protected $fillable = [
        'user_id',
        'student_topic_id',
        'session_date',
        'end_date',
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
        return $this->belongsTo(StudentTopic::class);
    }

    public function comments()
    {
        return $this->hasMany(MentoringComment::class);
    }
public function latestComment()
{
    return $this->hasOne(MentoringComment::class)
        ->ofMany(
            // Argumen 1: Tentukan kolom pengurutan untuk mencari yang terbaru
            ['id' => 'max'], 
            
            // Argumen 2: Terapkan filter whereNull di sini
            function ($query) {
                $query->whereNull('parent_comment_id');
            }
        );
}

  public function countComments()
{
   return $this->comments()
        ->whereNull('parent_comment_id')
        ->count();

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
