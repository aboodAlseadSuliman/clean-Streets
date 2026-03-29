<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['vehicle_case_id', 'from_status', 'to_status', 'changed_by_user_id', 'reason', 'created_at'])]
class CaseStatusLog extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    public function vehicleCase(): BelongsTo
    {
        return $this->belongsTo(VehicleCase::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by_user_id');
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }
}
