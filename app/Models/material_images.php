<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class material_images extends Model
{
      use HasFactory;

    protected $fillable = [
        'material_id',
        'image_url',
    ];

    public function material()
    {
        return $this->belongsTo(learning_materials::class);
    }
}
