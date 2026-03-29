<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'case_number',
    'source_report_id',
    'owning_agency_id',
    'district_id',
    'neighborhood_id',
    'location_text',
    'nearest_landmark',
    'google_maps_url',
    'latitude',
    'longitude',
    'vehicle_type',
    'damage_type',
    'plate_number',
    'color',
    'make_model',
    'priority',
    'current_status',
    'reports_count',
    'first_reported_at',
    'last_reported_at',
    'verified_at',
    'removed_at',
    'closed_at',
    'created_by_user_id',
])]
class VehicleCase extends Model
{
    use HasFactory;

    public function sourceReport(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'source_report_id');
    }

    public function owningAgency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'owning_agency_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function neighborhood(): BelongsTo
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function caseAttachments(): HasMany
    {
        return $this->hasMany(CaseAttachment::class);
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    public function caseAssignments(): HasMany
    {
        return $this->hasMany(CaseAssignment::class);
    }

    public function removals(): HasMany
    {
        return $this->hasMany(Removal::class);
    }

    public function caseStatusLogs(): HasMany
    {
        return $this->hasMany(CaseStatusLog::class);
    }

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'reports_count' => 'integer',
            'first_reported_at' => 'datetime',
            'last_reported_at' => 'datetime',
            'verified_at' => 'datetime',
            'removed_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }
}
