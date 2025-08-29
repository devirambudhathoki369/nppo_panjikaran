<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pest',
    ];

    public function recommendedPests()
    {
        return $this->hasMany(RecommendedPest::class, 'pest_id');
    }
}