<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\AssignmentUpdate;
use App\Models\CaseAssignment;
use App\Models\CaseAttachment;
use App\Models\CaseStatusLog;
use App\Models\Citizen;
use App\Models\District;
use App\Models\Inspection;
use App\Models\Neighborhood;
use App\Models\Removal;
use App\Models\Report;
use App\Models\ReportAttachment;
use App\Models\User;
use App\Models\VehicleCase;
use App\Support\ReportWorkflowService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DemoOperationalSeeder extends Seeder
{
    protected array $agencies = [];

    protected array $users = [];

    protected array $citizens = [];

    protected array $districts = [];

    protected array $neighborhoods = [];

    protected ReportWorkflowService $workflow;

    public function run(): void
    {
        $this->workflow = app(ReportWorkflowService::class);
        $this->loadReferenceMaps();

        DB::transaction(function (): void {
            $this->seedIncomingReports();
            $this->seedVerifiedCase();
            $this->seedInProgressCase();
            $this->seedScheduledRemovalCase();
            $this->seedRemovedCase();
            $this->seedRejectedCase();
        });
    }

    protected function loadReferenceMaps(): void
    {
        $this->agencies = Agency::query()->get()->keyBy('type')->all();
        $this->users = User::query()->get()->keyBy('email')->all();
        $this->citizens = Citizen::query()->get()->keyBy('phone')->all();
        $this->districts = District::query()->get()->keyBy('code')->all();
        $this->neighborhoods = Neighborhood::query()->get()->keyBy('code')->all();
    }

    protected function seedIncomingReports(): void
    {
        $report = $this->upsertReport([
            'tracking_code' => 'CS-DEMO-1001',
            'citizen_id' => $this->citizens['0551000001']->id,
            'submitted_by_user_id' => null,
            'request_type' => 'vehicle_removal',
            'submission_channel' => 'web',
            'subject' => 'بلاغ سيارة متضررة أمام حديقة الروضة',
            'complaint_details' => 'يوجد هيكل سيارة متروك منذ أكثر من أسبوعين ويعيق المواقف القريبة من الحديقة.',
            'address_text' => 'شارع الأمير ماجد، مقابل حديقة الروضة',
            'nearest_landmark' => 'حديقة الروضة',
            'district_id' => $this->districts['north']->id,
            'neighborhood_id' => $this->neighborhoods['north-rawda']->id,
            'google_maps_url' => $this->googleMapsUrl(24.7995100, 46.7001200),
            'latitude' => 24.7995100,
            'longitude' => 46.7001200,
            'vehicle_type' => 'sedan',
            'damage_type' => 'abandoned_wreck',
            'plate_number' => null,
            'color' => 'أبيض',
            'make_model' => 'تويوتا كامري',
            'public_status' => 'received',
            'internal_status' => 'submitted',
            'review_note' => null,
            'submitted_at' => now()->subDay()->setTime(8, 30),
            'reviewed_at' => null,
            'closed_at' => null,
        ]);

        $this->upsertReportAttachment(
            $report,
            'citizen-note.txt',
            'مرفق تجريبي يوضح أن البلاغ ما زال بانتظار المراجعة.',
            'ملاحظة أولية من مقدم البلاغ',
        );

        $this->upsertReport([
            'tracking_code' => 'CS-DEMO-1002',
            'citizen_id' => $this->citizens['0551000002']->id,
            'submitted_by_user_id' => $this->users['reviewer@cleanstreets.test']->id,
            'request_type' => 'vehicle_removal',
            'submission_channel' => 'phone_entry',
            'subject' => 'بلاغ هاتفي قيد المراجعة',
            'complaint_details' => 'المركبة متوقفة قرب مدخل المدرسة وتحتاج للتحقق من نطاق الصلاحية قبل فتح حالة.',
            'address_text' => 'طريق الملك عبدالعزيز، بجوار مدرسة السليمانية',
            'nearest_landmark' => 'مدرسة السليمانية',
            'district_id' => $this->districts['central']->id,
            'neighborhood_id' => $this->neighborhoods['central-sulaimania']->id,
            'google_maps_url' => $this->googleMapsUrl(24.6911100, 46.6899100),
            'latitude' => 24.6911100,
            'longitude' => 46.6899100,
            'vehicle_type' => 'pickup',
            'damage_type' => 'partially_damaged',
            'plate_number' => 'ر ل م 4821',
            'color' => 'أزرق',
            'make_model' => 'نيسان ددسن',
            'public_status' => 'under_review',
            'internal_status' => 'reviewing',
            'review_note' => 'تم تحويل البلاغ للمراجعة الأولية من قبل الموظف المختص.',
            'submitted_at' => now()->subHours(18),
            'reviewed_at' => now()->subHours(12),
            'closed_at' => null,
        ]);
    }

    protected function seedVerifiedCase(): void
    {
        $submittedAt = now()->subDays(6)->setTime(9, 15);
        $reviewedAt = $submittedAt->copy()->addHours(3);
        $verifiedAt = $submittedAt->copy()->addDay()->setTime(11, 0);

        $report = $this->upsertReport([
            'tracking_code' => 'CS-DEMO-2001',
            'citizen_id' => $this->citizens['0551000003']->id,
            'submitted_by_user_id' => null,
            'request_type' => 'vehicle_removal',
            'submission_channel' => 'web',
            'subject' => 'سيارة محترقة بجوار مسجد الندى',
            'complaint_details' => 'السيارة محترقة بالكامل ومتروكة بجانب سور المسجد.',
            'address_text' => 'شارع الندى العام، بجوار مسجد الندى',
            'nearest_landmark' => 'مسجد الندى',
            'district_id' => $this->districts['north']->id,
            'neighborhood_id' => $this->neighborhoods['north-nada']->id,
            'google_maps_url' => $this->googleMapsUrl(24.8061000, 46.6842100),
            'latitude' => 24.8061000,
            'longitude' => 46.6842100,
            'vehicle_type' => 'sedan',
            'damage_type' => 'burned',
            'plate_number' => null,
            'color' => 'أسود',
            'make_model' => 'هيونداي أكسنت',
            'public_status' => 'in_progress',
            'internal_status' => 'linked_to_case',
            'review_note' => 'تم إنشاء حالة للتحقق الميداني والمتابعة.',
            'submitted_at' => $submittedAt,
            'reviewed_at' => $reviewedAt,
            'closed_at' => null,
        ]);

        $case = $this->upsertCaseFromReport($report, [
            'case_number' => 'VC-DEMO-3001',
            'owning_agency_id' => $this->agencies['municipality']->id,
            'priority' => 'high',
            'current_status' => 'verified',
            'verified_at' => $verifiedAt,
            'removed_at' => null,
            'closed_at' => null,
            'created_by_user_id' => $this->users['reviewer@cleanstreets.test']->id,
        ]);

        $this->upsertStatusLog($case, null, 'new', $this->users['reviewer@cleanstreets.test'], 'تم فتح الحالة من البلاغ الأساسي.', $reviewedAt);
        $this->upsertStatusLog($case, 'new', 'under_review', $this->users['reviewer@cleanstreets.test'], 'بدأت المراجعة المكتبية.', $reviewedAt->copy()->addHour());
        $this->upsertStatusLog($case, 'under_review', 'verified', $this->users['inspector@cleanstreets.test'], 'أكدت المعاينة أن المركبة ضمن نطاق الإزالة.', $verifiedAt);

        $this->upsertInspection([
            'vehicle_case_id' => $case->id,
            'inspector_user_id' => $this->users['inspector@cleanstreets.test']->id,
            'agency_id' => $this->agencies['municipality']->id,
            'inspection_result' => 'confirmed',
            'notes' => 'المركبة محترقة بالكامل ولا توجد لوحة واضحة، وتم رفع توصية بالإزالة.',
            'inspected_at' => $verifiedAt,
        ]);

        $this->upsertCaseAttachment(
            $case,
            $this->users['inspector@cleanstreets.test'],
            'inspection',
            'inspection-summary.txt',
            'ملخص ميداني: المركبة ثابتة في الموقع ولا تظهر عليها أي حركة حديثة.',
            'ملخص معاينة ميدانية',
        );

        $duplicateReport = $this->upsertReport([
            'tracking_code' => 'CS-DEMO-2002',
            'citizen_id' => $this->citizens['0551000004']->id,
            'submitted_by_user_id' => null,
            'request_type' => 'vehicle_removal',
            'submission_channel' => 'web',
            'subject' => 'بلاغ مكرر عن سيارة محترقة',
            'complaint_details' => 'المركبة نفسها موجودة منذ أيام بجوار المسجد ولم تتم إزالتها بعد.',
            'address_text' => 'شارع الندى العام، بجوار مسجد الندى',
            'nearest_landmark' => 'مسجد الندى',
            'district_id' => $this->districts['north']->id,
            'neighborhood_id' => $this->neighborhoods['north-nada']->id,
            'google_maps_url' => $this->googleMapsUrl(24.8061000, 46.6842100),
            'latitude' => 24.8061000,
            'longitude' => 46.6842100,
            'vehicle_type' => 'sedan',
            'damage_type' => 'burned',
            'plate_number' => null,
            'color' => 'أسود',
            'make_model' => 'هيونداي أكسنت',
            'public_status' => 'in_progress',
            'internal_status' => 'duplicate',
            'review_note' => 'تم اعتبار البلاغ مكررًا وربطه بالحالة VC-DEMO-3001.',
            'submitted_at' => $submittedAt->copy()->addHours(8),
            'reviewed_at' => $verifiedAt->copy()->addHour(),
            'closed_at' => null,
        ]);

        $this->linkReportToCase(
            $duplicateReport,
            $case,
            'duplicate',
            'اعتُبر البلاغ مكررًا وربط بالحالة VC-DEMO-3001.',
            $verifiedAt->copy()->addHour(),
        );

        $this->syncCaseStats($case);
    }

    protected function seedInProgressCase(): void
    {
        $submittedAt = now()->subDays(5)->setTime(10, 20);
        $reviewedAt = $submittedAt->copy()->addHours(2);
        $verifiedAt = $submittedAt->copy()->addDay()->setTime(9, 40);
        $assignedAt = $verifiedAt->copy()->addHours(3);

        $report = $this->upsertReport([
            'tracking_code' => 'CS-DEMO-3001',
            'citizen_id' => $this->citizens['0551000005']->id,
            'submitted_by_user_id' => null,
            'request_type' => 'vehicle_removal',
            'submission_channel' => 'web',
            'subject' => 'شاحنة متضررة بجوار سوق الملز',
            'complaint_details' => 'الشاحنة تشغل جزءًا من الطريق الفرعي وتسبب تضييقًا على المارة.',
            'address_text' => 'شارع السوق الداخلي، خلف سوق الملز',
            'nearest_landmark' => 'سوق الملز',
            'district_id' => $this->districts['central']->id,
            'neighborhood_id' => $this->neighborhoods['central-malaz']->id,
            'google_maps_url' => $this->googleMapsUrl(24.6677000, 46.7378200),
            'latitude' => 24.6677000,
            'longitude' => 46.7378200,
            'vehicle_type' => 'truck',
            'damage_type' => 'destroyed',
            'plate_number' => 'س ك ن 9924',
            'color' => 'أصفر',
            'make_model' => 'مرسيدس شاحنة',
            'public_status' => 'in_progress',
            'internal_status' => 'linked_to_case',
            'review_note' => 'تم تحويل البلاغ إلى حالة تنفيذية ومخاطبة الجهة المسؤولة.',
            'submitted_at' => $submittedAt,
            'reviewed_at' => $reviewedAt,
            'closed_at' => null,
        ]);

        $case = $this->upsertCaseFromReport($report, [
            'case_number' => 'VC-DEMO-3002',
            'owning_agency_id' => $this->agencies['municipality']->id,
            'priority' => 'critical',
            'current_status' => 'in_progress',
            'verified_at' => $verifiedAt,
            'removed_at' => null,
            'closed_at' => null,
            'created_by_user_id' => $this->users['reviewer@cleanstreets.test']->id,
        ]);

        $this->upsertStatusLog($case, null, 'new', $this->users['reviewer@cleanstreets.test'], 'تم فتح الحالة وربطها بالبلاغ الأساسي.', $reviewedAt);
        $this->upsertStatusLog($case, 'new', 'verified', $this->users['inspector@cleanstreets.test'], 'تم تأكيد خطورة الوضع ميدانيًا.', $verifiedAt);
        $this->upsertStatusLog($case, 'verified', 'assigned', $this->users['municipality-admin@cleanstreets.test'], 'أُسندت الحالة إلى البلدية للتنفيذ.', $assignedAt);
        $this->upsertStatusLog($case, 'assigned', 'in_progress', $this->users['municipality-admin@cleanstreets.test'], 'بدأ فريق التنفيذ تجهيز الموقع والرفع.', $assignedAt->copy()->addHours(4));

        $this->upsertInspection([
            'vehicle_case_id' => $case->id,
            'inspector_user_id' => $this->users['inspector@cleanstreets.test']->id,
            'agency_id' => $this->agencies['municipality']->id,
            'inspection_result' => 'confirmed',
            'notes' => 'الشاحنة مدمرة وتعيق الحركة في الممر الجانبي.',
            'inspected_at' => $verifiedAt,
        ]);

        $assignment = $this->upsertAssignment([
            'vehicle_case_id' => $case->id,
            'agency_id' => $this->agencies['municipality']->id,
            'assigned_to_user_id' => $this->users['municipality-admin@cleanstreets.test']->id,
            'assigned_by_user_id' => $this->users['reviewer@cleanstreets.test']->id,
            'assignment_status' => 'in_progress',
            'assigned_at' => $assignedAt,
            'responded_at' => $assignedAt->copy()->addHour(),
            'due_at' => $assignedAt->copy()->addDays(2),
            'completed_at' => null,
            'notes' => 'الأولوية عالية بسبب تضييق الطريق.',
        ]);

        $this->upsertAssignmentUpdate($assignment, $this->users['municipality-admin@cleanstreets.test'], 'accepted', 'تم استلام الإسناد واعتماد فريق المعالجة.', $assignedAt->copy()->addHour());
        $this->upsertAssignmentUpdate($assignment, $this->users['inspector@cleanstreets.test'], 'field_visit', 'تمت زيارة الموقع ميدانيًا مع تحديد احتياج لرافعة.', $assignedAt->copy()->addHours(5));
        $this->upsertAssignmentUpdate($assignment, $this->users['municipality-admin@cleanstreets.test'], 'note', 'بانتظار توفر شاحنة سحب خلال الساعات القادمة.', $assignedAt->copy()->addHours(9));

        $this->upsertCaseAttachment(
            $case,
            $this->users['municipality-admin@cleanstreets.test'],
            'general',
            'execution-note.txt',
            'ملف تجريبي: جرى تنسيق المعدات اللازمة لبدء السحب.',
            'مذكرة تنفيذية',
        );
    }

    protected function seedScheduledRemovalCase(): void
    {
        $submittedAt = now()->subDays(4)->setTime(13, 0);
        $reviewedAt = $submittedAt->copy()->addHours(2);
        $verifiedAt = $submittedAt->copy()->addDay()->setTime(10, 30);
        $scheduledAt = now()->addDay()->setTime(7, 30);

        $report = $this->upsertReport([
            'tracking_code' => 'CS-DEMO-4001',
            'citizen_id' => $this->citizens['0551000006']->id,
            'submitted_by_user_id' => null,
            'request_type' => 'vehicle_removal',
            'submission_channel' => 'web',
            'subject' => 'حافلة مهجورة قرب محطة النقل',
            'complaint_details' => 'الحافلة متوقفة في نفس الموقع منذ فترة طويلة وتحتاج إزالة مجدولة.',
            'address_text' => 'الطريق الخدمي، بجوار محطة النقل الجنوبية',
            'nearest_landmark' => 'محطة النقل الجنوبية',
            'district_id' => $this->districts['south']->id,
            'neighborhood_id' => $this->neighborhoods['south-badr']->id,
            'google_maps_url' => $this->googleMapsUrl(24.5543100, 46.7545000),
            'latitude' => 24.5543100,
            'longitude' => 46.7545000,
            'vehicle_type' => 'bus',
            'damage_type' => 'abandoned_wreck',
            'plate_number' => null,
            'color' => 'أبيض وأخضر',
            'make_model' => 'حافلة نقل قديمة',
            'public_status' => 'in_progress',
            'internal_status' => 'linked_to_case',
            'review_note' => 'تم جدولة المعالجة بالتنسيق مع إدارة النقل.',
            'submitted_at' => $submittedAt,
            'reviewed_at' => $reviewedAt,
            'closed_at' => null,
        ]);

        $case = $this->upsertCaseFromReport($report, [
            'case_number' => 'VC-DEMO-3003',
            'owning_agency_id' => $this->agencies['transport']->id,
            'priority' => 'medium',
            'current_status' => 'scheduled_for_removal',
            'verified_at' => $verifiedAt,
            'removed_at' => null,
            'closed_at' => null,
            'created_by_user_id' => $this->users['reviewer@cleanstreets.test']->id,
        ]);

        $this->upsertStatusLog($case, null, 'new', $this->users['reviewer@cleanstreets.test'], 'تم تسجيل الحالة من البلاغ الأساسي.', $reviewedAt);
        $this->upsertStatusLog($case, 'new', 'verified', $this->users['inspector@cleanstreets.test'], 'أكدت المعاينة أن الحافلة مهجورة.', $verifiedAt);
        $this->upsertStatusLog($case, 'verified', 'scheduled_for_removal', $this->users['transport-user@cleanstreets.test'], 'تم تحديد موعد السحب الميداني.', $verifiedAt->copy()->addHours(6));

        $this->upsertInspection([
            'vehicle_case_id' => $case->id,
            'inspector_user_id' => $this->users['inspector@cleanstreets.test']->id,
            'agency_id' => $this->agencies['municipality']->id,
            'inspection_result' => 'confirmed',
            'notes' => 'الحافلة غير صالحة للحركة وتحتاج ناقلة خاصة.',
            'inspected_at' => $verifiedAt,
        ]);

        $assignment = $this->upsertAssignment([
            'vehicle_case_id' => $case->id,
            'agency_id' => $this->agencies['transport']->id,
            'assigned_to_user_id' => $this->users['transport-user@cleanstreets.test']->id,
            'assigned_by_user_id' => $this->users['reviewer@cleanstreets.test']->id,
            'assignment_status' => 'received',
            'assigned_at' => $verifiedAt->copy()->addHours(3),
            'responded_at' => $verifiedAt->copy()->addHours(4),
            'due_at' => $scheduledAt,
            'completed_at' => null,
            'notes' => 'الحالة مجدولة للتنفيذ صباح الغد.',
        ]);

        $this->upsertAssignmentUpdate($assignment, $this->users['transport-user@cleanstreets.test'], 'accepted', 'تم استلام المهمة من إدارة النقل.', $verifiedAt->copy()->addHours(4));
        $this->upsertAssignmentUpdate($assignment, $this->users['transport-user@cleanstreets.test'], 'scheduled', 'تم حجز ناقلة وسائق للموعد المحدد.', $verifiedAt->copy()->addHours(7));

        $this->upsertRemoval([
            'vehicle_case_id' => $case->id,
            'case_assignment_id' => $assignment->id,
            'agency_id' => $this->agencies['transport']->id,
            'executed_by_user_id' => $this->users['transport-user@cleanstreets.test']->id,
            'scheduled_at' => $scheduledAt,
            'started_at' => null,
            'completed_at' => null,
            'destination' => 'ساحة الحجز الجنوبية',
            'result' => null,
            'notes' => 'عملية مجدولة ولم تبدأ بعد.',
        ]);
    }

    protected function seedRemovedCase(): void
    {
        $submittedAt = now()->subDays(9)->setTime(7, 50);
        $reviewedAt = $submittedAt->copy()->addHours(4);
        $verifiedAt = $submittedAt->copy()->addDay()->setTime(9, 10);
        $assignedAt = $verifiedAt->copy()->addHours(2);
        $startedAt = $submittedAt->copy()->addDays(2)->setTime(8, 0);
        $completedAt = $submittedAt->copy()->addDays(2)->setTime(11, 20);

        $report = $this->upsertReport([
            'tracking_code' => 'CS-DEMO-5001',
            'citizen_id' => $this->citizens['0551000002']->id,
            'submitted_by_user_id' => null,
            'request_type' => 'vehicle_removal',
            'submission_channel' => 'web',
            'subject' => 'مركبة متهالكة أمام السوق الشعبي',
            'complaint_details' => 'تم إهمال المركبة منذ فترة وهي تشغل مساحة من المواقف العامة.',
            'address_text' => 'مواقف السوق الشعبي، قرب المدخل الجنوبي',
            'nearest_landmark' => 'السوق الشعبي',
            'district_id' => $this->districts['south']->id,
            'neighborhood_id' => $this->neighborhoods['south-azizia']->id,
            'google_maps_url' => $this->googleMapsUrl(24.6088300, 46.7380900),
            'latitude' => 24.6088300,
            'longitude' => 46.7380900,
            'vehicle_type' => 'pickup',
            'damage_type' => 'partially_damaged',
            'plate_number' => 'ج س ح 1508',
            'color' => 'فضي',
            'make_model' => 'فورد رينجر',
            'public_status' => 'resolved',
            'internal_status' => 'linked_to_case',
            'review_note' => 'تمت المعالجة والإزالة بنجاح.',
            'submitted_at' => $submittedAt,
            'reviewed_at' => $reviewedAt,
            'closed_at' => $completedAt,
        ]);

        $case = $this->upsertCaseFromReport($report, [
            'case_number' => 'VC-DEMO-3004',
            'owning_agency_id' => $this->agencies['recycling']->id,
            'priority' => 'high',
            'current_status' => 'removed',
            'verified_at' => $verifiedAt,
            'removed_at' => $completedAt,
            'closed_at' => $completedAt->copy()->addHour(),
            'created_by_user_id' => $this->users['reviewer@cleanstreets.test']->id,
        ]);

        $this->upsertStatusLog($case, null, 'new', $this->users['reviewer@cleanstreets.test'], 'تم إنشاء الحالة وربطها بالبلاغ.', $reviewedAt);
        $this->upsertStatusLog($case, 'new', 'verified', $this->users['inspector@cleanstreets.test'], 'تم تأكيد الحاجة إلى الإزالة.', $verifiedAt);
        $this->upsertStatusLog($case, 'verified', 'assigned', $this->users['recycling-user@cleanstreets.test'], 'أُسندت الحالة إلى شركة التدوير.', $assignedAt);
        $this->upsertStatusLog($case, 'assigned', 'scheduled_for_removal', $this->users['recycling-user@cleanstreets.test'], 'تم إدراج المركبة في جدول السحب.', $assignedAt->copy()->addHours(5));
        $this->upsertStatusLog($case, 'scheduled_for_removal', 'removed', $this->users['recycling-user@cleanstreets.test'], 'أزيلت المركبة ونُقلت إلى ساحة الحجز.', $completedAt);

        $this->upsertInspection([
            'vehicle_case_id' => $case->id,
            'inspector_user_id' => $this->users['inspector@cleanstreets.test']->id,
            'agency_id' => $this->agencies['municipality']->id,
            'inspection_result' => 'confirmed',
            'notes' => 'المركبة غير مستخدمة وتفتقد بعض الأجزاء الأساسية.',
            'inspected_at' => $verifiedAt,
        ]);

        $assignment = $this->upsertAssignment([
            'vehicle_case_id' => $case->id,
            'agency_id' => $this->agencies['recycling']->id,
            'assigned_to_user_id' => $this->users['recycling-user@cleanstreets.test']->id,
            'assigned_by_user_id' => $this->users['reviewer@cleanstreets.test']->id,
            'assignment_status' => 'completed',
            'assigned_at' => $assignedAt,
            'responded_at' => $assignedAt->copy()->addHour(),
            'due_at' => $submittedAt->copy()->addDays(3),
            'completed_at' => $completedAt,
            'notes' => 'نُفذت المهمة ضمن الجدول المحدد.',
        ]);

        $this->upsertAssignmentUpdate($assignment, $this->users['recycling-user@cleanstreets.test'], 'accepted', 'تم اعتماد المهمة وتجهيز فريق الرفع.', $assignedAt->copy()->addHour());
        $this->upsertAssignmentUpdate($assignment, $this->users['recycling-user@cleanstreets.test'], 'scheduled', 'تمت إضافة المركبة لخطة العمل اليومية.', $assignedAt->copy()->addHours(5));
        $this->upsertAssignmentUpdate($assignment, $this->users['recycling-user@cleanstreets.test'], 'completed', 'اكتملت الإزالة وتسليم الموقع.', $completedAt);

        $this->upsertRemoval([
            'vehicle_case_id' => $case->id,
            'case_assignment_id' => $assignment->id,
            'agency_id' => $this->agencies['recycling']->id,
            'executed_by_user_id' => $this->users['recycling-user@cleanstreets.test']->id,
            'scheduled_at' => $startedAt->copy()->subHour(),
            'started_at' => $startedAt,
            'completed_at' => $completedAt,
            'destination' => 'ساحة الحجز المركزية',
            'result' => 'removed',
            'notes' => 'تم السحب برافعة خفيفة دون عوائق.',
        ]);

        $this->upsertCaseAttachment(
            $case,
            $this->users['recycling-user@cleanstreets.test'],
            'removal',
            'removal-report.txt',
            'تم تنفيذ الإزالة بالكامل ونقل المركبة إلى الساحة المعتمدة.',
            'تقرير تنفيذ الإزالة',
        );
    }

    protected function seedRejectedCase(): void
    {
        $submittedAt = now()->subDays(3)->setTime(15, 10);
        $reviewedAt = $submittedAt->copy()->addHours(2);
        $closedAt = $submittedAt->copy()->addDay()->setTime(12, 15);

        $report = $this->upsertReport([
            'tracking_code' => 'CS-DEMO-6001',
            'citizen_id' => $this->citizens['0551000001']->id,
            'submitted_by_user_id' => null,
            'request_type' => 'vehicle_removal',
            'submission_channel' => 'web',
            'subject' => 'بلاغ عن مركبة خارج نطاق البلدية',
            'complaint_details' => 'الموقع يقع داخل أرض خاصة ولا يمكن اتخاذ إجراء مباشر دون تنسيق إضافي.',
            'address_text' => 'استراحة خاصة خلف حي الشفا',
            'nearest_landmark' => 'مدخل الاستراحة',
            'district_id' => $this->districts['south']->id,
            'neighborhood_id' => $this->neighborhoods['south-shifa']->id,
            'google_maps_url' => $this->googleMapsUrl(24.5629100, 46.7261000),
            'latitude' => 24.5629100,
            'longitude' => 46.7261000,
            'vehicle_type' => 'motorcycle',
            'damage_type' => 'unknown',
            'plate_number' => null,
            'color' => 'أحمر',
            'make_model' => 'دراجة نارية',
            'public_status' => 'rejected',
            'internal_status' => 'linked_to_case',
            'review_note' => 'أُغلقت الحالة لكون الموقع خارج نطاق الإجراء المباشر.',
            'submitted_at' => $submittedAt,
            'reviewed_at' => $reviewedAt,
            'closed_at' => $closedAt,
        ]);

        $case = $this->upsertCaseFromReport($report, [
            'case_number' => 'VC-DEMO-3005',
            'owning_agency_id' => $this->agencies['district_committee']->id,
            'priority' => 'low',
            'current_status' => 'rejected',
            'verified_at' => null,
            'removed_at' => null,
            'closed_at' => $closedAt,
            'created_by_user_id' => $this->users['reviewer@cleanstreets.test']->id,
        ]);

        $this->upsertStatusLog($case, null, 'new', $this->users['reviewer@cleanstreets.test'], 'تم فتح الحالة للمراجعة الأولية.', $reviewedAt);
        $this->upsertStatusLog($case, 'new', 'under_review', $this->users['reviewer@cleanstreets.test'], 'جارٍ التحقق من النطاق النظامي.', $reviewedAt->copy()->addMinutes(40));
        $this->upsertStatusLog($case, 'under_review', 'rejected', $this->users['inspector@cleanstreets.test'], 'تبيّن أن الموقع داخل ملكية خاصة وخارج نطاق المعالجة المباشرة.', $closedAt);

        $this->upsertInspection([
            'vehicle_case_id' => $case->id,
            'inspector_user_id' => $this->users['inspector@cleanstreets.test']->id,
            'agency_id' => $this->agencies['municipality']->id,
            'inspection_result' => 'out_of_scope',
            'notes' => 'الموقع داخل نطاق خاص ويحتاج مسارًا مختلفًا للمعالجة.',
            'inspected_at' => $closedAt->copy()->subHour(),
        ]);
    }

    protected function upsertReport(array $attributes): Report
    {
        return Report::query()->updateOrCreate(
            ['tracking_code' => $attributes['tracking_code']],
            $attributes,
        );
    }

    protected function upsertCaseFromReport(Report $report, array $attributes): VehicleCase
    {
        $case = VehicleCase::query()->updateOrCreate(
            ['case_number' => $attributes['case_number']],
            [
                'source_report_id' => $report->id,
                'owning_agency_id' => $attributes['owning_agency_id'],
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
                'priority' => $attributes['priority'],
                'current_status' => $attributes['current_status'],
                'reports_count' => 1,
                'first_reported_at' => $report->submitted_at,
                'last_reported_at' => $report->submitted_at,
                'verified_at' => $attributes['verified_at'],
                'removed_at' => $attributes['removed_at'],
                'closed_at' => $attributes['closed_at'],
                'created_by_user_id' => $attributes['created_by_user_id'],
            ],
        );

        $this->linkReportToCase(
            $report,
            $case,
            'linked_to_case',
            $report->review_note,
            $report->reviewed_at ?? now(),
        );

        return $case;
    }

    protected function linkReportToCase(
        Report $report,
        VehicleCase $case,
        string $internalStatus,
        ?string $note,
        $reviewedAt,
    ): void {
        $closedAt = in_array($case->current_status, ['removed', 'closed', 'rejected'], true)
            ? ($case->closed_at ?? $reviewedAt)
            : null;

        $report->forceFill([
            'vehicle_case_id' => $case->id,
            'internal_status' => $internalStatus,
            'public_status' => $this->workflow->resolvePublicStatusFromCase($case),
            'review_note' => $note,
            'reviewed_at' => $reviewedAt,
            'closed_at' => $closedAt,
        ])->save();
    }

    protected function syncCaseStats(VehicleCase $case): void
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

    protected function upsertInspection(array $attributes): Inspection
    {
        return Inspection::query()->updateOrCreate(
            [
                'vehicle_case_id' => $attributes['vehicle_case_id'],
                'inspection_result' => $attributes['inspection_result'],
                'inspected_at' => $attributes['inspected_at'],
            ],
            $attributes,
        );
    }

    protected function upsertAssignment(array $attributes): CaseAssignment
    {
        return CaseAssignment::query()->updateOrCreate(
            [
                'vehicle_case_id' => $attributes['vehicle_case_id'],
                'agency_id' => $attributes['agency_id'],
            ],
            $attributes,
        );
    }

    protected function upsertAssignmentUpdate(
        CaseAssignment $assignment,
        User $user,
        string $type,
        string $message,
        $createdAt,
    ): AssignmentUpdate {
        return AssignmentUpdate::query()->updateOrCreate(
            [
                'case_assignment_id' => $assignment->id,
                'update_type' => $type,
                'created_at' => $createdAt,
            ],
            [
                'agency_id' => $assignment->agency_id,
                'user_id' => $user->id,
                'message' => $message,
            ],
        );
    }

    protected function upsertRemoval(array $attributes): Removal
    {
        return Removal::query()->updateOrCreate(
            [
                'vehicle_case_id' => $attributes['vehicle_case_id'],
                'agency_id' => $attributes['agency_id'],
            ],
            $attributes,
        );
    }

    protected function upsertStatusLog(
        VehicleCase $case,
        ?string $fromStatus,
        string $toStatus,
        ?User $changedBy,
        ?string $reason,
        $createdAt,
    ): CaseStatusLog {
        return CaseStatusLog::query()->updateOrCreate(
            [
                'vehicle_case_id' => $case->id,
                'to_status' => $toStatus,
                'created_at' => $createdAt,
            ],
            [
                'from_status' => $fromStatus,
                'changed_by_user_id' => $changedBy?->id,
                'reason' => $reason,
            ],
        );
    }

    protected function upsertReportAttachment(
        Report $report,
        string $fileName,
        string $contents,
        ?string $caption = null,
    ): ReportAttachment {
        $filePath = "seeders/reports/{$report->tracking_code}/{$fileName}";
        Storage::disk('public')->put($filePath, $contents);

        return ReportAttachment::query()->updateOrCreate(
            [
                'report_id' => $report->id,
                'file_path' => $filePath,
            ],
            [
                'file_name' => $fileName,
                'mime_type' => 'text/plain',
                'file_size' => strlen($contents),
                'caption' => $caption,
            ],
        );
    }

    protected function upsertCaseAttachment(
        VehicleCase $case,
        ?User $uploadedBy,
        string $category,
        string $fileName,
        string $contents,
        ?string $notes = null,
    ): CaseAttachment {
        $filePath = "seeders/cases/{$case->case_number}/{$fileName}";
        Storage::disk('public')->put($filePath, $contents);

        return CaseAttachment::query()->updateOrCreate(
            [
                'vehicle_case_id' => $case->id,
                'file_path' => $filePath,
            ],
            [
                'uploaded_by_user_id' => $uploadedBy?->id,
                'category' => $category,
                'file_name' => $fileName,
                'mime_type' => 'text/plain',
                'file_size' => strlen($contents),
                'notes' => $notes,
            ],
        );
    }

    protected function googleMapsUrl(float $latitude, float $longitude): string
    {
        return "https://maps.google.com/?q={$latitude},{$longitude}";
    }
}
