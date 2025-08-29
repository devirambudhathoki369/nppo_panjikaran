<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendedPest extends Model
{
    use HasFactory;

    protected $fillable = [
        'checklist_id',
        'panjikaran_id',
        'pest_id',
    ];

    protected $casts = [
        'checklist_id' => 'integer',
        'panjikaran_id' => 'integer',
        'pest_id' => 'integer',
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'checklist_id');
    }

    public function panjikaran()
    {
        return $this->belongsTo(Panjikaran::class, 'panjikaran_id');
    }

    public function pest()
    {
        return $this->belongsTo(Pest::class, 'pest_id');
    }
}