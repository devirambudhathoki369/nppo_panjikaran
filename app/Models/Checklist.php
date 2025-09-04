<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'Status' => 'integer',
        'ApplicationType' => 'integer',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'CreatedBy');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'VerifiedBY');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'ApprovedBy');
    }

    public function formulation()
    {
        return $this->belongsTo(Formulation::class, 'formulation_id');
    }

    public function bishadiType()
    {
        return $this->belongsTo(BishadiType::class, 'bishadi_type_id');
    }

    public function details()
    {
        return $this->hasMany(ChecklistDetail::class, 'ChecklistID');
    }

    public function check_list_containers()
    {
        return $this->hasMany(CheckListContainer::class, 'checklist_id');
    }

    public function check_list_formulations()
    {
        return $this->hasMany(CheckListFormulation::class, 'checklist_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'CountryID')->withDefault();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function containers()
    {
        return $this->hasMany(CheckListContainer::class, 'checklist_id');
    }

    /**
     * Check if checklist is sent to verification
     */
    public function isSentToVerification()
    {
        return $this->notifications()
            ->where('action_type', 'send_to_verify')
            ->exists();
    }

    /**
     * Check if checklist is sent to approval
     */
    public function isSentToApproval()
    {
        return $this->notifications()
            ->where('action_type', 'send_to_approve')
            ->exists();
    }

    /**
     * Check if user can edit this checklist
     */
    public function canEdit($userId = null)
    {
        $userId = $userId ?? auth()->id();
        $userType = auth()->user()->usertype;

        // Admin can always edit if status is 0 and not sent to verify
        if ($userType == 'admin') {
            return $this->Status == 0 && !$this->isSentToVerification();
        }

        // User can edit if:
        // 1. They are the creator
        // 2. Status is 0 (initial)
        // 3. Not sent to verification yet
        if ($userType == 'user') {
            return $this->CreatedBy == $userId
                && $this->Status == 0
                && !$this->isSentToVerification();
        }

        return false;
    }

    /**
     * Check if user can delete this checklist
     */
    public function canDelete($userId = null)
    {
        // Same rules as edit for now
        return $this->canEdit($userId);
    }

    /**
     * Check if user can send to verify
     */
    public function canSendToVerify($userId = null)
    {
        $userId = $userId ?? auth()->id();
        $userType = auth()->user()->usertype;

        // Can send to verify if can edit and not already sent
        return $this->canEdit($userId) && !$this->isSentToVerification();
    }

    /**
     * Get the latest comment for current user
     */
    public function getLatestCommentForUser($userId = null)
    {
        $userId = $userId ?? auth()->id();

        return $this->notifications()
            ->where('to_user_id', $userId)
            ->where('action_type', 'send_back')
            ->latest()
            ->first();
    }

    /**
     * Get all comments for this checklist
     */
    public function getAllComments()
    {
        return $this->notifications()
            ->where('action_type', 'send_back')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get status with icon and label
     */
    public function getStatusWithIcon()
    {
        switch ($this->Status) {
            case 0:
                if ($this->isSentToVerification()) {
                    return '<span class="badge bg-warning"><i class="fas fa-clock"></i> सिफारीसको प्रतीक्षामा</span>';
                }
                return '<span class="badge bg-secondary"><i class="fas fa-edit"></i> प्रारम्भिक दर्ता</span>';
            case 1:
                if ($this->isSentToApproval()) {
                    return '<span class="badge bg-info"><i class="fas fa-clock"></i> स्वीकृतिको प्रतीक्षामा</span>';
                }
                return '<span class="badge bg-primary"><i class="fas fa-check-circle"></i> सिफारीस भएको</span>';
            case 2:
                return '<span class="badge bg-success"><i class="fas fa-medal"></i> स्वीकृत भएको</span>';
            default:
                return '<span class="badge bg-danger"><i class="fas fa-question"></i> अज्ञात</span>';
        }
    }

    /**
     * Get current status user
     */
    public function currentStatusUser()
    {
        if ($this->Status == 0) {
            return $this->creator ? $this->creator->name : 'N/A';
        } elseif ($this->Status == 1) {
            return $this->verifier ? $this->verifier->name : 'N/A';
        } elseif ($this->Status == 2) {
            return $this->approver ? $this->approver->name : 'N/A';
        }
        return 'N/A';
    }

    /**
     * Get current status date in Nepali
     */
    public function currentStatusDateNep()
    {
        if ($this->Status == 0 && $this->CreatedDate) {
            return Date::engToNep($this->CreatedDate);
        } elseif ($this->Status == 1 && $this->VerifiedDate) {
            return Date::engToNep($this->VerifiedDate);
        } elseif ($this->Status == 2 && $this->ApprovedDate) {
            return Date::engToNep($this->ApprovedDate);
        }
        return null;
    }

    public function getCreatedDateNepaliAttribute()
    {
        return $this->CreatedDate ? Date::engToNep($this->CreatedDate) : null;
    }

    public function getVerifiedDateNepaliAttribute()
    {
        return $this->VerifiedDate ? Date::engToNep($this->VerifiedDate) : null;
    }

    public function getApprovedDateNepaliAttribute()
    {
        return $this->ApprovedDate ? Date::engToNep($this->ApprovedDate) : null;
    }

    /**
     * Scope to get checklists visible to current user
     */
    public function scopeVisibleToUser($query, $userId = null)
    {
        $userId = $userId ?? auth()->id();
        $userType = auth()->user()->usertype;

        if ($userType == 'admin') {
            // Admin sees all
            return $query;
        } elseif ($userType == 'user') {
            // User sees only their own
            return $query->where('CreatedBy', $userId);
        } elseif ($userType == 'verifier') {
            // Verifier sees documents sent to them and verified/approved ones
            $sentToMe = Notification::where('to_user_id', $userId)
                ->where('action_type', 'send_to_verify')
                ->pluck('checklist_id');

            return $query->where(function ($q) use ($sentToMe) {
                $q->whereIn('id', $sentToMe)
                    ->orWhereIn('Status', [1, 2]);
            });
        } elseif ($userType == 'approver') {
            // Approver sees only verified and approved documents
            return $query->whereIn('Status', [1, 2]);
        }

        return $query->whereRaw('1 = 0'); // Return empty if unknown user type
    }
}
