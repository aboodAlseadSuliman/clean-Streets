<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'vehicle_case_id',
    'case_assignment_id',
    'agency_id',
    'executed_by_user_id',
    'scheduled_at',
    'started_at',
    'completed_at',
    'destination',
    'result',
    'notes',
])]
class Removal extends Model
{
    use HasFactory;

    public function vehicleCase(): BelongsTo
    {
        return $this->belongsTo(VehicleCase::class);
    }

    public function caseAssignment(): BelongsTo
    {
        return $this->belongsTo(CaseAssignment::class);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function executedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'executed_by_user_id');
    }

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }
}
