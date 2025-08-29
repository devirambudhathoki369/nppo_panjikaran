<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendedCrop extends Model
{
    use HasFactory;

    protected $fillable = [
        'checklist_id',
        'panjikaran_id',
        'crop_id',
    ];

    protected $casts = [
        'checklist_id' => 'integer',
        'panjikaran_id' => 'integer',
        'crop_id' => 'integer',
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'checklist_id');
    }

    public function panjikaran()
    {
        return $this->belongsTo(Panjikaran::class, 'panjikaran_id');
    }

    public function crop()
    {
        return $this->belongsTo(Crop::class, 'crop_id');
    }
}