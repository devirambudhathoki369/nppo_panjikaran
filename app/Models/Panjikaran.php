<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panjikaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'ChecklistID',
        'CommonNameOfPesticide',
        'ChemicalName',
        'IUPAC_Name',
        'Cas_No',
        'Atomic_Formula',
        'SourceID',
        'ObjectiveID',
        'UsageID',
        'DapperQuantity',
        'DQUnitID',
        'Waiting_duration',
        'FirstAid',
        'PackageDestroyID',
        'Foreign_producer_company_name',
        'Foreign_producer_company_address',
        'Nepali_producer_company_name',
        'Nepali_producer_company_address',
        'Nepali_producer_company_email',
        'Nepali_producer_company_contact',
        'Samejasamcompany_s_detail_name',
        'Samejasamcompany_s_detail_address',
        'Samejasamcompany_s_detail_email',
        'Samejasamcompany_s_detail_contact',
        'Packing_company_details_name',
        'Packing_company_details_address',
        'Packing_company_details_email',
        'Packing_company_details_contact',
        'Paitharkarta_company_details_name',
        'Paitharkarta_company_details_address',
        'Paitharkarta_company_details_email',
        'Paitharkarta_company_details_contact',
    ];

    protected $casts = [
        'ChecklistID' => 'integer',
        'SourceID' => 'integer',
        'ObjectiveID' => 'integer',
        'UsageID' => 'integer',
        'DQUnitID' => 'integer',
        'PackageDestroyID' => 'integer',
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'ChecklistID');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'SourceID');
    }

    public function objective()
    {
        return $this->belongsTo(Objective::class, 'ObjectiveID');
    }

    public function usage()
    {
        return $this->belongsTo(Usage::class, 'UsageID');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'DQUnitID');
    }

    public function packageDestroy()
    {
        return $this->belongsTo(PackageDestroy::class, 'PackageDestroyID');
    }

    public function bargikarans()
    {
        return $this->hasMany(Bargikaran::class, 'panjikaran_id');
    }

    public function recommendedCrops()
    {
        return $this->hasMany(RecommendedCrop::class, 'panjikaran_id');
    }

    public function recommendedPests()
    {
        return $this->hasMany(RecommendedPest::class, 'panjikaran_id');
    }

    public function hcsDetails()
    {
        return $this->hasMany(HcsDetail::class, 'panjikaran_id');
    }

    public function nnswDetails()
    {
        return $this->hasMany(NnswDetail::class, 'panjikaran_id');
    }
}
