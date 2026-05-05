<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialVideo extends Model
{
    protected $table='material_videos';
     protected $fillable = [
        'material_id',
        'video_url',
        'description'
    ];

    public function material_video()
    {
        return $this->belongsTo(LearningMaterial::class);
    }
}
