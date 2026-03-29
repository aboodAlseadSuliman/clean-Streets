<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['full_name', 'phone', 'whatsapp_phone', 'email', 'preferred_contact_method', 'notes'])]
class Citizen extends Model
{
    use HasFactory;

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
