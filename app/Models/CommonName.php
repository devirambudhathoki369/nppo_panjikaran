<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommonName extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'common_name',
        'rasayanik_name',
        'iupac_name',
        'cas_no',
        'molecular_formula',
        'source_id',
    ];

    // Relationship with Source model
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
}
