<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HcsDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'checklist_id',
        'panjikaran_id',
        'hcs_code',
        'self_life_of_the_product',
        'tax_payment_bhauchar_details',
        'date'
    ];

    protected $casts = [
        'date' => 'date'
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
