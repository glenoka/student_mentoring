<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mentoring_comments extends Model
{
   use HasFactory;

    protected $fillable = [
        'mentoring_session_id',
        'parent_id',
        'teacher_id',
        'parent_comment_id',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function session()
    {
        return $this->belongsTo(mentoring_sessions::class, 'mentoring_session_id');
    }

    public function parent()
    {
        return $this->belongsTo(parents::class, 'parent_id');
    }

    public function teacher()
    {
        return $this->belongsTo(teachers::class, 'teacher_id');
    }

    // Threading
    public function parentComment()
    {
        return $this->belongsTo(mentoring_comments::class, 'parent_comment_id');
    }

    public function replies()
    {
        return $this->hasMany(mentoring_comments::class, 'parent_comment_id');
    }

    // Helper: siapa pengirim
    public function getSenderAttribute()
    {
        return $this->teacher_id ? 'teacher' : 'parent';
    }
}
