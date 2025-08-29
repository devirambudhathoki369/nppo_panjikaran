<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommonName extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'common_name',
    ];
}
