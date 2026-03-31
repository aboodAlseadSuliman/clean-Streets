<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublicReportRequest;
use App\Models\Citizen;
use App\Models\District;
use App\Models\Neighborhood;
use App\Models\Report;
use App\Models\ReportAttachment;
use App\Support\CleanStreetsOptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\View\View;

class PublicReportController extends Controller
{
    public function create(): View
    {
        try {
            $districts = District::query()->orderBy('name')->get(['id', 'name']);
        } catch (Throwable $exception) {
            report($exception);

            $districts = collect();
        }

        return view('public.report-form', [
            'districts' => $districts,
            'vehicleTypes' => CleanStreetsOptions::vehicleTypes(),
            'damageTypes' => CleanStreetsOptions::damageTypes(),
            'contactMethods' => CleanStreetsOptions::contactMethods(),
        ]);
    }

    public function store(StorePublicReportRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $trackingCode = DB::transaction(function () use ($request, $validated): string {
                $citizen = Citizen::firstOrNew([
                    'phone' => $validated['phone'],
                ]);

                $citizen->fill([
                    'full_name' => $validated['full_name'],
                    'phone' => $validated['phone'],
                    'whatsapp_phone' => $validated['whatsapp_phone'] ?? null,
                    'email' => $validated['email'] ?? null,
                    'preferred_contact_method' => $validated['preferred_contact_method'] ?? null,
                ]);
                $citizen->save();

                $trackingCode = $this->generateTrackingCode();

                $report = Report::create([
                    'tracking_code' => $trackingCode,
                    'citizen_id' => $citizen->id,
                    'request_type' => 'vehicle_removal',
                    'submission_channel' => 'web',
                    'subject' => filled($validated['subject'] ?? null) ? $validated['subject'] : 'بلاغ إزالة سيارة متضررة',
                    'complaint_details' => $validated['complaint_details'],
                    'address_text' => $validated['address_text'],
                    'nearest_landmark' => $validated['nearest_landmark'] ?? null,
                    'district_id' => $validated['district_id'] ?? null,
                    'neighborhood_id' => $validated['neighborhood_id'] ?? null,
                    'google_maps_url' => $validated['google_maps_url'] ?? null,
                    'latitude' => $validated['latitude'] ?? null,
                    'longitude' => $validated['longitude'] ?? null,
                    'vehicle_type' => $validated['vehicle_type'] ?? null,
                    'damage_type' => $validated['damage_type'] ?? null,
                    'plate_number' => $validated['plate_number'] ?? null,
                    'color' => $validated['color'] ?? null,
                    'make_model' => $validated['make_model'] ?? null,
                    'public_status' => 'received',
                    'internal_status' => 'submitted',
                    'submitted_at' => now(),
                ]);

                foreach ($request->file('attachments', []) as $attachment) {
                    $path = $attachment->storePublicly("reports/{$report->id}", [
                        'disk' => 'public',
                        'visibility' => 'public',
                    ]);

                    ReportAttachment::create([
                        'report_id' => $report->id,
                        'file_path' => $path,
                        'file_name' => $attachment->getClientOriginalName(),
                        'mime_type' => $attachment->getClientMimeType() ?: $attachment->getMimeType() ?: 'application/octet-stream',
                        'file_size' => $attachment->getSize(),
                        'caption' => null,
                    ]);
                }

                return $trackingCode;
            });
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'general' => 'تعذر حفظ البلاغ حاليًا. يرجى المحاولة بعد قليل أو التواصل مع الجهة المعنية مباشرة.',
                ]);
        }

        return redirect()->route('public.reports.success', ['trackingCode' => $trackingCode]);
    }

    public function success(string $trackingCode): View
    {
        return view('public.report-success', [
            'trackingCode' => $trackingCode,
        ]);
    }

    public function neighborhoods(District $district): JsonResponse
    {
        try {
            $data = Neighborhood::query()
                ->where('district_id', $district->id)
                ->orderBy('name')
                ->get(['id', 'name']);
        } catch (Throwable $exception) {
            report($exception);

            $data = collect();
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    private function generateTrackingCode(): string
    {
        do {
            $code = 'CS-' . now()->format('ymd') . '-' . Str::upper(Str::random(6));
        } while (Report::query()->where('tracking_code', $code)->exists());

        return $code;
    }
}
