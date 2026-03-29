<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['vehicle_case_id', 'inspector_user_id', 'agency_id', 'inspection_result', 'notes', 'inspected_at'])]
class Inspection extends Model
{
    use HasFactory;

    public function vehicleCase(): BelongsTo
    {
        return $this->belongsTo(VehicleCase::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_user_id');
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    protected function casts(): array
    {
        return [
            'inspected_at' => 'datetime',
        ];
    }
}
