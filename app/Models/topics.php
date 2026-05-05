<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Topics extends Model
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
        return $this->hasMany(StudentTopic::class);
    }

    public function materials()
    {
        return $this->hasMany(LearningMaterial::class);
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
