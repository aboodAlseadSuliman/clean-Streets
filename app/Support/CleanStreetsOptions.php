<?php

namespace App\Support;

class CleanStreetsOptions
{
    public static function agencyTypes(): array
    {
        return [
            'municipality' => 'بلدية',
            'traffic' => 'مرور',
            'transport' => 'نقل',
            'recycling' => 'تدوير / معادن',
            'district_committee' => 'لجنة حي',
            'other' => 'أخرى',
        ];
    }

    public static function userRoles(): array
    {
        return [
            'super_admin' => 'مدير عام',
            'reviewer' => 'مراجع طلبات',
            'inspector' => 'مراقب ميداني',
            'agency_user' => 'مستخدم جهة',
            'municipality_admin' => 'مسؤول بلدية',
            'traffic_admin' => 'مسؤول مرور',
        ];
    }

    public static function contactMethods(): array
    {
        return [
            'phone' => 'هاتف',
            'whatsapp' => 'واتساب',
            'email' => 'بريد إلكتروني',
        ];
    }

    public static function requestTypes(): array
    {
        return [
            'vehicle_removal' => 'طلب إزالة سيارة',
            'obstruction' => 'إعاقة طريق',
            'follow_up' => 'متابعة طلب',
            'other' => 'أخرى',
        ];
    }

    public static function submissionChannels(): array
    {
        return [
            'web' => 'الويب',
            'whatsapp_entry' => 'إدخال واتساب',
            'phone_entry' => 'إدخال هاتفي',
            'field_entry' => 'إدخال ميداني',
            'internal_entry' => 'إدخال داخلي',
        ];
    }

    public static function vehicleTypes(): array
    {
        return [
            'sedan' => 'سياحية',
            'pickup' => 'بيك أب',
            'truck' => 'شاحنة',
            'bus' => 'باص',
            'motorcycle' => 'دراجة',
            'unknown' => 'غير معروف',
        ];
    }

    public static function damageTypes(): array
    {
        return [
            'burned' => 'محروقة',
            'destroyed' => 'مدمرة',
            'abandoned_wreck' => 'هيكل متروك',
            'partially_damaged' => 'متضررة جزئيًا',
            'unknown' => 'غير معروف',
        ];
    }

    public static function reportPublicStatuses(): array
    {
        return [
            'received' => 'تم الاستلام',
            'under_review' => 'قيد المراجعة',
            'in_progress' => 'قيد المعالجة',
            'resolved' => 'تم الحل',
            'closed' => 'مغلق',
            'rejected' => 'مرفوض',
        ];
    }

    public static function reportInternalStatuses(): array
    {
        return [
            'submitted' => 'وارد',
            'reviewing' => 'تحت المراجعة',
            'linked_to_case' => 'مرتبط بحالة',
            'duplicate' => 'مكرر',
            'rejected' => 'مرفوض',
            'closed' => 'مغلق',
        ];
    }

    public static function casePriorities(): array
    {
        return [
            'low' => 'منخفضة',
            'medium' => 'متوسطة',
            'high' => 'عالية',
            'critical' => 'حرجة',
        ];
    }

    public static function caseStatuses(): array
    {
        return [
            'new' => 'جديدة',
            'under_review' => 'تحت المراجعة',
            'verified' => 'مؤكدة',
            'assigned' => 'مسندة',
            'in_progress' => 'قيد التنفيذ',
            'scheduled_for_removal' => 'مجدولة للإزالة',
            'removed' => 'أزيلت',
            'closed' => 'مغلقة',
            'rejected' => 'مرفوضة',
        ];
    }

    public static function attachmentCategories(): array
    {
        return [
            'inspection' => 'تحقق ميداني',
            'removal' => 'إزالة',
            'official_document' => 'مستند رسمي',
            'general' => 'عام',
        ];
    }

    public static function inspectionResults(): array
    {
        return [
            'confirmed' => 'مؤكد',
            'not_found' => 'غير موجود',
            'duplicate' => 'مكرر',
            'out_of_scope' => 'خارج النطاق',
            'deferred' => 'مؤجل',
        ];
    }

    public static function assignmentStatuses(): array
    {
        return [
            'sent' => 'مرسل',
            'received' => 'مستلم',
            'in_progress' => 'قيد التنفيذ',
            'waiting_external_action' => 'بانتظار جهة أخرى',
            'completed' => 'مكتمل',
            'returned' => 'معاد',
            'cancelled' => 'ملغي',
        ];
    }

    public static function assignmentUpdateTypes(): array
    {
        return [
            'note' => 'ملاحظة',
            'accepted' => 'تم القبول',
            'field_visit' => 'زيارة ميدانية',
            'awaiting_approval' => 'بانتظار الموافقة',
            'scheduled' => 'تمت الجدولة',
            'completed' => 'مكتمل',
            'rejected' => 'مرفوض',
            'returned' => 'معاد',
        ];
    }

    public static function removalResults(): array
    {
        return [
            'removed' => 'تمت الإزالة',
            'partially_removed' => 'إزالة جزئية',
            'failed' => 'فشل التنفيذ',
            'cancelled' => 'ملغي',
        ];
    }
}
