<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bargikaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'checklist_id',
        'panjikaran_id',
        'code',
        'make',
    ];

    protected $casts = [
        'checklist_id' => 'integer',
        'panjikaran_id' => 'integer',
        'code' => 'integer',
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'checklist_id');
    }

    public function panjikaran()
    {
        return $this->belongsTo(Panjikaran::class, 'panjikaran_id');
    }
}
