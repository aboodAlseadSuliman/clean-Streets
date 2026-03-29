<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'vehicle_case_id',
    'agency_id',
    'assigned_to_user_id',
    'assigned_by_user_id',
    'assignment_status',
    'assigned_at',
    'responded_at',
    'due_at',
    'completed_at',
    'notes',
])]
class CaseAssignment extends Model
{
    use HasFactory;

    public function vehicleCase(): BelongsTo
    {
        return $this->belongsTo(VehicleCase::class);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by_user_id');
    }

    public function updates(): HasMany
    {
        return $this->hasMany(AssignmentUpdate::class);
    }

    public function removals(): HasMany
    {
        return $this->hasMany(Removal::class);
    }

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'responded_at' => 'datetime',
            'due_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }
}
