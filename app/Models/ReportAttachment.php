<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['report_id', 'file_path', 'file_name', 'mime_type', 'file_size', 'caption'])]
class ReportAttachment extends Model
{
    use HasFactory;

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
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
