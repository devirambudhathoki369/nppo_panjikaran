<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckListContainer extends Model
{
    protected $guarded = [];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'checklist_id');
    }

    public function container()
    {
        return $this->belongsTo(Container::class, 'container_id');
    }


    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
