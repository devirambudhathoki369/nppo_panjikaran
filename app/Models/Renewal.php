<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Renewal extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'checklist_id',
        'panjikaran_id',
        'renew_date',
        'renew_expiry_date',
        'tax_bhauchar_no',
        'ruju_garne',
        'signature_upload',
    ];

    protected $casts = [
        'renew_date' => 'date',
        'renew_expiry_date' => 'date',
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function panjikaran()
    {
        return $this->belongsTo(Panjikaran::class);
    }

    // Helper method to get status based on expiry date
    public function getStatusAttribute()
    {
        if ($this->renew_expiry_date->isPast()) {
            return 'expired';
        } elseif ($this->renew_expiry_date->diffInDays(now()) <= 30) {
            return 'expiring_soon';
        } else {
            return 'active';
        }
    }

    public function getStatusWithIconAttribute()
    {
        switch ($this->status) {
            case 'expired':
                return '<span class="badge bg-danger">म्याद सकिएको</span>';
            case 'expiring_soon':
                return '<span class="badge bg-warning">छिट्टै म्याद सक्ने</span>';
            default:
                return '<span class="badge bg-success">सक्रिय</span>';
        }
    }
}
