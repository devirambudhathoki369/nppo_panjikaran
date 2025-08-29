<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistDetail extends Model
{
    use HasFactory;

    protected $table = 'checklist_details';
    protected $primaryKey = 'id';

    protected $guarded = [];

    // Constants for DocumentStatus
    const STATUS_YES = '0';
    const STATUS_NO = '1';

    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'ChecklistID');
    }

    public function checklistItem()
    {
        return $this->belongsTo(ChecklistItem::class, 'ChecklistItemID');
    }

    public function getStatusTextAttribute()
    {
        return match ($this->DocumentStatus) {
            self::STATUS_YES => 'Yes',
            self::STATUS_NO => 'No',
            default => 'Unknown',
        };
    }
}
