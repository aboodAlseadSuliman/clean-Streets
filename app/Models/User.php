<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['agency_id', 'name', 'email', 'phone', 'password', 'role', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return (bool) $this->is_active;
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function createdVehicleCases(): HasMany
    {
        return $this->hasMany(VehicleCase::class, 'created_by_user_id');
    }

    public function submittedReports(): HasMany
    {
        return $this->hasMany(Report::class, 'submitted_by_user_id');
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class, 'inspector_user_id');
    }

    public function assignedCaseAssignments(): HasMany
    {
        return $this->hasMany(CaseAssignment::class, 'assigned_to_user_id');
    }

    public function createdCaseAssignments(): HasMany
    {
        return $this->hasMany(CaseAssignment::class, 'assigned_by_user_id');
    }

    public function caseAttachments(): HasMany
    {
        return $this->hasMany(CaseAttachment::class, 'uploaded_by_user_id');
    }

    public function assignmentUpdates(): HasMany
    {
        return $this->hasMany(AssignmentUpdate::class);
    }

    public function removals(): HasMany
    {
        return $this->hasMany(Removal::class, 'executed_by_user_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }
}
