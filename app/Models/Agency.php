<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'type', 'phone', 'email', 'address', 'is_active'])]
class Agency extends Model
{
    use HasFactory;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function ownedVehicleCases(): HasMany
    {
        return $this->hasMany(VehicleCase::class, 'owning_agency_id');
    }

    public function caseAssignments(): HasMany
    {
        return $this->hasMany(CaseAssignment::class);
    }

    public function assignmentUpdates(): HasMany
    {
        return $this->hasMany(AssignmentUpdate::class);
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    public function removals(): HasMany
    {
        return $this->hasMany(Removal::class);
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
