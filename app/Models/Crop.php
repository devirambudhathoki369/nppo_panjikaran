<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_name',
    ];

    public function recommendedCrops()
    {
        return $this->hasMany(RecommendedCrop::class, 'crop_id');
    }
}