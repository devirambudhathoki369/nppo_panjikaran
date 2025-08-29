<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formulation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'formulation_name',
    ];
}
