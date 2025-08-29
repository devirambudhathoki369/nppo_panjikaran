<?php
// app/Models/BishadiType.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BishadiType extends Model
{
    use HasFactory;

    protected $fillable = [
        'prakar',
        'type_code'
    ];

    protected $table = 'bishadi_types';

    public function checklist()
    {
        $this->hasMany(Checklist::class);
    }

    public function panjikarans()
    {
        return $this->hasMany(Panjikaran::class, 'CategoryID');
    }
}
