<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'tracking_code',
    'citizen_id',
    'vehicle_case_id',
    'submitted_by_user_id',
    'request_type',
    'submission_channel',
    'subject',
    'complaint_details',
    'address_text',
    'nearest_landmark',
    'district_id',
    'neighborhood_id',
    'google_maps_url',
    'latitude',
    'longitude',
    'vehicle_type',
    'damage_type',
    'plate_number',
    'color',
    'make_model',
    'public_status',
    'internal_status',
    'review_note',
    'submitted_at',
    'reviewed_at',
    'closed_at',
])]
class Report extends Model
{
    use HasFactory;

    public function citizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class);
    }

    public function vehicleCase(): BelongsTo
    {
        return $this->belongsTo(VehicleCase::class);
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by_user_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function neighborhood(): BelongsTo
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ReportAttachment::class);
    }

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }
}
