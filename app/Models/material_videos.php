<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class material_videos extends Model
{
     protected $fillable = [
        'material_id',
        'video_url',
        'description'
    ];

    public function material_video()
    {
        return $this->belongsTo(learning_materials::class);
    }
}
