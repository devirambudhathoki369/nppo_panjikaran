<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckListFormulation extends Model
{
    protected $guarded = [];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'checklist_id')->withDefault();
    }

    public function common_name()
    {
        return $this->belongsTo(CommonName::class, 'common_name_id')->withDefault();
    }

    public function formulation()
    {
        return $this->belongsTo(Formulation::class, 'formulation_id')->withDefault();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id')->withDefault();
    }
}
