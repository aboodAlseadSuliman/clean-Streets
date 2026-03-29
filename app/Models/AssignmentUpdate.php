<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['case_assignment_id', 'agency_id', 'user_id', 'update_type', 'message', 'created_at'])]
class AssignmentUpdate extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    public function caseAssignment(): BelongsTo
    {
        return $this->belongsTo(CaseAssignment::class);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }
}
