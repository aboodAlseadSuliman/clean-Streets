<?php

namespace App\Support;

use App\Models\CaseStatusLog;
use App\Models\Report;
use App\Models\VehicleCase;
use Illuminate\Support\Str;

class ReportWorkflowService
{
    public function createCaseFromReport(Report $report, array $data, ?int $userId = null): VehicleCase
    {
        $report->loadMissing('vehicleCase');

        if ($report->vehicleCase) {
            return $report->vehicleCase;
        }

        $case = VehicleCase::create([
            'case_number' => $data['case_number'] ?? $this->generateCaseNumber(),
            'source_report_id' => $report->id,
            'owning_agency_id' => $data['owning_agency_id'] ?? null,
            'district_id' => $report->district_id,
            'neighborhood_id' => $report->neighborhood_id,
            'location_text' => $report->address_text,
            'nearest_landmark' => $report->nearest_landmark,
            'google_maps_url' => $report->google_maps_url,
            'latitude' => $report->latitude,
            'longitude' => $report->longitude,
            'vehicle_type' => $report->vehicle_type ?: 'unknown',
            'damage_type' => $report->damage_type ?: 'unknown',
            'plate_number' => $report->plate_number,
            'color' => $report->color,
            'make_model' => $report->make_model,
            'priority' => $data['priority'] ?? 'medium',
            'current_status' => $data['current_status'] ?? 'new',
            'reports_count' => 0,
            'first_reported_at' => $report->submitted_at ?? now(),
            'last_reported_at' => $report->submitted_at ?? now(),
            'created_by_user_id' => $userId,
        ]);

        $this->updateReportForCase(
            report: $report,
            case: $case,
            internalStatus: 'linked_to_case',
            systemNote: "تم إنشاء الحالة {$case->case_number} من هذا البلاغ.",
            userNote: $data['review_note'] ?? null,
        );

        CaseStatusLog::create([
            'vehicle_case_id' => $case->id,
            'from_status' => null,
            'to_status' => $case->current_status,
            'changed_by_user_id' => $userId,
            'reason' => $this->combineNoteSegments([
                "تم إنشاء الحالة من البلاغ {$report->tracking_code}.",
                $data['review_note'] ?? null,
            ]),
            'created_at' => now(),
        ]);

        $this->syncCaseReportStats($case);

        return $case->fresh();
    }

    public function linkToExistingCase(
        Report $report,
        VehicleCase $case,
        ?string $note = null,
        bool $markAsDuplicate = false,
    ): Report {
        $previousCaseId = $report->vehicle_case_id;

        if (! $case->source_report_id) {
            $case->forceFill([
                'source_report_id' => $report->id,
            ])->save();
        }

        $this->updateReportForCase(
            report: $report,
            case: $case,
            internalStatus: $markAsDuplicate ? 'duplicate' : 'linked_to_case',
            systemNote: $markAsDuplicate
                ? "اعتُبر البلاغ مكررًا وربط بالحالة {$case->case_number}."
                : "تم ربط البلاغ بالحالة {$case->case_number}.",
            userNote: $note,
        );

        $this->syncCaseReportStats($case);

        if ($previousCaseId && ($previousCaseId !== $case->id)) {
            $previousCase = VehicleCase::find($previousCaseId);

            if ($previousCase) {
                $this->syncCaseReportStats($previousCase);
            }
        }

        return $report->fresh();
    }

    public function generateCaseNumber(): string
    {
        do {
            $caseNumber = 'VC-' . now()->format('ymd') . '-' . Str::upper(Str::random(6));
        } while (VehicleCase::query()->where('case_number', $caseNumber)->exists());

        return $caseNumber;
    }

    public function resolvePublicStatusFromCase(VehicleCase $case): string
    {
        return match ($case->current_status) {
            'removed', 'closed' => 'resolved',
            'rejected' => 'rejected',
            default => 'in_progress',
        };
    }

    public function syncCaseReportStats(VehicleCase $case): void
    {
        $stats = $case->reports()
            ->selectRaw('COUNT(*) as aggregate_count, MIN(submitted_at) as first_reported_at, MAX(submitted_at) as last_reported_at')
            ->first();

        $case->forceFill([
            'reports_count' => (int) ($stats?->aggregate_count ?? 0),
            'first_reported_at' => $stats?->first_reported_at,
            'last_reported_at' => $stats?->last_reported_at,
        ])->save();
    }

    protected function updateReportForCase(
        Report $report,
        VehicleCase $case,
        string $internalStatus,
        string $systemNote,
        ?string $userNote = null,
    ): void {
        $report->forceFill([
            'vehicle_case_id' => $case->id,
            'internal_status' => $internalStatus,
            'public_status' => $this->resolvePublicStatusFromCase($case),
            'review_note' => $this->combineNoteSegments([
                $report->review_note,
                $systemNote,
                $userNote,
            ]),
            'reviewed_at' => now(),
            'closed_at' => in_array($case->current_status, ['removed', 'closed', 'rejected'], true) ? now() : null,
        ])->save();
    }

    protected function combineNoteSegments(array $segments): ?string
    {
        $segments = array_values(array_filter(
            array_map(
                static fn (?string $segment): ?string => filled(trim((string) $segment)) ? trim((string) $segment) : null,
                $segments,
            ),
        ));

        return $segments === [] ? null : implode("\n\n", $segments);
    }
}
