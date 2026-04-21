<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class learning_materials extends Model
{
   use HasFactory;

    protected $fillable = [
        'topic_id',
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
}
