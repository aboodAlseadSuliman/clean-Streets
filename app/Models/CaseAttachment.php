<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'vehicle_case_id',
    'uploaded_by_user_id',
    'category',
    'file_path',
    'file_name',
    'mime_type',
    'file_size',
    'notes',
])]
class CaseAttachment extends Model
{
    use HasFactory;

    public function vehicleCase(): BelongsTo
    {
        return $this->belongsTo(VehicleCase::class);
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
        ];
    }

    protected function getPublicUrlAttribute(): ?string
    {
        if (blank($this->file_path)) {
            return null;
        }

        return url("storage/{$this->file_path}");
    }
}
