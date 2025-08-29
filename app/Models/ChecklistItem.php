<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $table = 'checklist_items';

    protected $fillable = [
        'CheckListItem',
        'Type'
    ];

    // Constants for Type
    const TYPE_IMPORTER = '0';
    const TYPE_PRODUCER = '1';
    const TYPE_BOTH = '2';

    public function getTypeTextAttribute()
    {
        return match ($this->Type) {
            self::TYPE_IMPORTER => checklistType($this->Type),
            self::TYPE_PRODUCER => checklistType($this->Type),
            self::TYPE_BOTH => checklistType($this->Type),
            default => 'Unknown',
        };
    }

    public function checklist_details()
    {
        return $this->hasMany(ChecklistDetail::class, 'CheckListItemID');
    }
}
