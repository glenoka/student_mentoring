<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class learning_materials extends Model
{
   use HasFactory;

    protected $fillable = [
        //'topic_id',
        'title',
        'type',
        'url',
        'order_number',
    ];

    public function topic()
    {
        return $this->belongsTo(topics::class);
    }

    public function images()
    {
        return $this->hasMany(material_images::class);
    }
    public function videos()
    {
        return $this->hasMany(material_videos::class);
    }
    public function getRouteKeyName()
{
    return 'uuid';
}
    protected static function booted()
{
    static::creating(function ($model) {
        if (empty($model->uuid)) {
            $model->uuid = (string) Str::uuid();
        }
    });
}
}
