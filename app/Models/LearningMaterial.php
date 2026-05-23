<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Teachers;

class LearningMaterial extends Model
{
   use HasFactory;
    protected $table='learning_materials';
    protected $fillable = [
        'description',
                'thumbnail',
                'teacher_id',
        'title',
        'type',
        'url',
        'order_number',
    ];

   

    public function images()
    {
        return $this->hasMany(MaterialImage::class);
    }
    public function videos()
    {
        return $this->hasMany(MaterialImage::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teachers::class);
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
