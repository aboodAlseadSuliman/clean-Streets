<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'code'])]
class District extends Model
{
    use HasFactory;

    public function neighborhoods(): HasMany
    {
        return $this->hasMany(Neighborhood::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function vehicleCases(): HasMany
    {
        return $this->hasMany(VehicleCase::class);
    }
}
