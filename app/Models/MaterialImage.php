<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialImage extends Model
{
      use HasFactory;
    protected $table='material_images';
    protected $fillable = [
        'material_id',
        'image_url',
        'description'
    ];

    public function material_image()
    {
        return $this->belongsTo(LearningMaterial::class);
    }
}
