<?php

namespace App\Filament\Resources\Reports\Pages\Concerns;

use App\Filament\Resources\VehicleCases\VehicleCaseResource;
use App\Models\Agency;
use App\Models\VehicleCase;
use App\Support\CleanStreetsOptions;
use App\Support\ReportWorkflowService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

trait HasReportWorkflowActions
{
    protected function getReportWorkflowActions(): array
    {
        return [
            $this->makeCreateCaseAction(),
            $this->makeLinkExistingCaseAction(),
            $this->makeMarkAsDuplicateAction(),
        ];
    }

    protected function makeCreateCaseAction(): Action
    {
        return Action::make('createCaseFromReport')
            ->label('إنشاء حالة من البلاغ')
            ->icon(Heroicon::OutlinedPlusCircle)
            ->color('success')
            ->modalHeading('إنشاء حالة ميدانية')
            ->modalDescription('سيتم إنشاء حالة جديدة من بيانات البلاغ وربطها مباشرة بهذا الطلب.')
            ->modalSubmitActionLabel('إنشاء الحالة')
            ->schema([
                TextInput::make('case_number')
                    ->label('رقم الحالة')
                    ->default(fn (): string => $this->reportWorkflow()->generateCaseNumber())
                    ->required()
                    ->maxLength(255)
                    ->rule(Rule::unique('vehicle_cases', 'case_number')),
                Select::make('priority')
                    ->label('الأولوية')
                    ->options(CleanStreetsOptions::casePriorities())
                    ->default('medium')
                    ->required(),
                Select::make('current_status')
                    ->label('الحالة الحالية')
                    ->options(CleanStreetsOptions::caseStatuses())
                    ->default('new')
                    ->required(),
                Select::make('owning_agency_id')
                    ->label('الجهة المالكة')
                    ->options(fn (): array => Agency::query()->orderBy('name')->pluck('name', 'id')->all())
                    ->searchable()
                    ->preload(),
                Textarea::make('review_note')
                    ->label('ملاحظة المراجعة')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->databaseTransaction()
            ->successNotificationTitle('تم إنشاء الحالة وربط البلاغ بها')
            ->successRedirectUrl(fn (): string => VehicleCaseResource::getUrl('view', [
                'record' => $this->getRecord()->fresh()->vehicle_case_id,
            ]))
            ->hidden(fn (): bool => filled($this->getRecord()->vehicle_case_id) || ($this->getRecord()->internal_status === 'duplicate'))
            ->action(function (array $data): void {
                $report = $this->getRecord()->fresh();

                if ($report->vehicle_case_id) {
                    throw ValidationException::withMessages([
                        'case_number' => 'هذا البلاغ مرتبط بحالة بالفعل.',
                    ]);
                }

                $this->reportWorkflow()->createCaseFromReport($report, $data, auth()->id());
                $this->refreshReportRecord();
            });
    }

    protected function makeLinkExistingCaseAction(): Action
    {
        return Action::make('linkToExistingCase')
            ->label('ربط بحالة موجودة')
            ->icon(Heroicon::OutlinedArrowsRightLeft)
            ->color('primary')
            ->modalHeading('ربط البلاغ بحالة موجودة')
            ->modalDescription('استخدم هذا الإجراء عندما تكون السيارة نفسها مسجلة مسبقًا ضمن حالة ميدانية قائمة.')
            ->modalSubmitActionLabel('ربط البلاغ')
            ->schema([
                $this->makeVehicleCaseSelect(),
                Textarea::make('review_note')
                    ->label('ملاحظة المراجعة')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->databaseTransaction()
            ->successNotificationTitle('تم ربط البلاغ بالحالة المختارة')
            ->successRedirectUrl(fn (): string => VehicleCaseResource::getUrl('view', [
                'record' => $this->getRecord()->fresh()->vehicle_case_id,
            ]))
            ->hidden(fn (): bool => filled($this->getRecord()->vehicle_case_id))
            ->action(function (array $data): void {
                $case = VehicleCase::query()->find($data['vehicle_case_id'] ?? null);

                if (! $case) {
                    throw ValidationException::withMessages([
                        'vehicle_case_id' => 'اختر حالة صحيحة للربط.',
                    ]);
                }

                $this->reportWorkflow()->linkToExistingCase(
                    report: $this->getRecord()->fresh(),
                    case: $case,
                    note: $data['review_note'] ?? null,
                    markAsDuplicate: false,
                );

                $this->refreshReportRecord();
            });
    }

    protected function makeMarkAsDuplicateAction(): Action
    {
        return Action::make('markReportAsDuplicate')
            ->label('اعتبار البلاغ مكررًا')
            ->icon(Heroicon::OutlinedDocumentDuplicate)
            ->color('warning')
            ->modalHeading('اعتبار البلاغ مكررًا')
            ->modalDescription('سيتم ربط البلاغ بالحالة الأصلية وتغيير حالته الداخلية إلى "مكرر".')
            ->modalSubmitActionLabel('تأكيد التكرار')
            ->schema([
                $this->makeVehicleCaseSelect()
                    ->default(fn (): ?int => $this->getRecord()->vehicle_case_id)
                    ->helperText('اختر الحالة الأصلية التي يتبع لها هذا البلاغ.'),
                Textarea::make('review_note')
                    ->label('سبب التكرار')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->databaseTransaction()
            ->successNotificationTitle('تم اعتبار البلاغ مكررًا وربطه بالحالة الأصلية')
            ->successRedirectUrl(fn (): string => VehicleCaseResource::getUrl('view', [
                'record' => $this->getRecord()->fresh()->vehicle_case_id,
            ]))
            ->hidden(fn (): bool => ($this->getRecord()->internal_status === 'duplicate') && filled($this->getRecord()->vehicle_case_id))
            ->action(function (array $data): void {
                $targetCaseId = $data['vehicle_case_id'] ?? $this->getRecord()->vehicle_case_id;
                $case = VehicleCase::query()->find($targetCaseId);

                if (! $case) {
                    throw ValidationException::withMessages([
                        'vehicle_case_id' => 'يجب اختيار الحالة الأصلية قبل اعتماد البلاغ كمكرر.',
                    ]);
                }

                $this->reportWorkflow()->linkToExistingCase(
                    report: $this->getRecord()->fresh(),
                    case: $case,
                    note: $data['review_note'],
                    markAsDuplicate: true,
                );

                $this->refreshReportRecord();
            });
    }

    protected function makeVehicleCaseSelect(): Select
    {
        return Select::make('vehicle_case_id')
            ->label('الحالة الأصلية')
            ->searchable()
            ->preload()
            ->required()
            ->options(fn (): array => $this->getRecentVehicleCaseOptions())
            ->getSearchResultsUsing(fn (string $search): array => $this->searchVehicleCaseOptions($search))
            ->getOptionLabelUsing(fn ($value): ?string => $this->resolveVehicleCaseOptionLabel($value));
    }

    protected function getRecentVehicleCaseOptions(): array
    {
        return VehicleCase::query()
            ->latest('last_reported_at')
            ->limit(50)
            ->get()
            ->mapWithKeys(fn (VehicleCase $case): array => [$case->id => $this->formatVehicleCaseOptionLabel($case)])
            ->all();
    }

    protected function searchVehicleCaseOptions(string $search): array
    {
        return VehicleCase::query()
            ->where(function (Builder $query) use ($search): void {
                $query
                    ->where('case_number', 'like', "%{$search}%")
                    ->orWhere('location_text', 'like', "%{$search}%")
                    ->orWhere('plate_number', 'like', "%{$search}%")
                    ->orWhere('make_model', 'like', "%{$search}%");
            })
            ->latest('last_reported_at')
            ->limit(50)
            ->get()
            ->mapWithKeys(fn (VehicleCase $case): array => [$case->id => $this->formatVehicleCaseOptionLabel($case)])
            ->all();
    }

    protected function resolveVehicleCaseOptionLabel(mixed $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $case = VehicleCase::query()->find($value);

        return $case ? $this->formatVehicleCaseOptionLabel($case) : null;
    }

    protected function formatVehicleCaseOptionLabel(VehicleCase $case): string
    {
        $location = Str::limit(trim((string) $case->location_text), 45);
        $plate = filled($case->plate_number) ? "لوحة: {$case->plate_number}" : null;

        return implode(' | ', array_filter([
            $case->case_number,
            $location,
            $plate,
        ]));
    }

    protected function refreshReportRecord(): void
    {
        $this->record = $this->getRecord()->fresh([
            'citizen',
            'vehicleCase',
            'district',
            'neighborhood',
        ]);

        if ($this instanceof EditRecord) {
            $this->fillForm();
        }
    }

    protected function reportWorkflow(): ReportWorkflowService
    {
        return app(ReportWorkflowService::class);
    }
}
