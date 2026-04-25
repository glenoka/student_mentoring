<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class topics extends Model
{
     use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'url',
        'description',
        'achievement',
        'strategy',
        'category',
    ];

    public function studentTopics()
    {
        return $this->hasMany(student_topics::class);
    }

    public function materials()
    {
        return $this->hasMany(learning_materials::class);
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
