<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NnswDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'checklist_id',
        'panjikaran_id',
        'nepal_rastriya_ekdwar_pranalima_anurodh_no',
        'nepal_rastriya_ekdwar_pranalima_anurodh_date',
        'company_code',
        'swikrit_no',
        'swikrit_date',
        'baidata_abadhi'
    ];

    protected $casts = [
        'nepal_rastriya_ekdwar_pranalima_anurodh_date' => 'date',
        'swikrit_date' => 'date'
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function panjikaran()
    {
        return $this->belongsTo(Panjikaran::class);
    }
}
