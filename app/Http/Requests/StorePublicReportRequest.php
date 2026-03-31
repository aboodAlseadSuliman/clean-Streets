<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePublicReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'whatsapp_phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'preferred_contact_method' => ['nullable', 'string', Rule::in(array_keys(\App\Support\CleanStreetsOptions::contactMethods()))],
            'subject' => ['nullable', 'string', 'max:255'],
            'complaint_details' => ['required', 'string', 'min:20'],
            'address_text' => ['required', 'string', 'min:8'],
            'nearest_landmark' => ['nullable', 'string', 'max:255'],
            'district_id' => ['nullable', 'integer', Rule::exists('districts', 'id')],
            'neighborhood_id' => [
                'nullable',
                'integer',
                Rule::exists('neighborhoods', 'id')->where(function ($query) {
                    if (filled($this->input('district_id'))) {
                        $query->where('district_id', $this->integer('district_id'));
                    }
                }),
            ],
            'google_maps_url' => ['nullable', 'url', 'max:65535'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'vehicle_type' => ['nullable', 'string', Rule::in(array_keys(\App\Support\CleanStreetsOptions::vehicleTypes()))],
            'damage_type' => ['nullable', 'string', Rule::in(array_keys(\App\Support\CleanStreetsOptions::damageTypes()))],
            'plate_number' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:255'],
            'make_model' => ['nullable', 'string', 'max:255'],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    public function attributes(): array
    {
        return [
            'full_name' => 'الاسم الكامل',
            'phone' => 'رقم الهاتف',
            'whatsapp_phone' => 'رقم الواتساب',
            'email' => 'البريد الإلكتروني',
            'preferred_contact_method' => 'وسيلة التواصل المفضلة',
            'subject' => 'عنوان البلاغ',
            'complaint_details' => 'تفاصيل الشكوى',
            'address_text' => 'العنوان',
            'nearest_landmark' => 'أقرب معلم',
            'district_id' => 'المنطقة',
            'neighborhood_id' => 'الحي',
            'google_maps_url' => 'رابط خرائط Google',
            'latitude' => 'خط العرض',
            'longitude' => 'خط الطول',
            'vehicle_type' => 'نوع السيارة',
            'damage_type' => 'حالة السيارة',
            'plate_number' => 'رقم اللوحة',
            'color' => 'لون السيارة',
            'make_model' => 'الماركة أو الموديل',
            'attachments' => 'الصور',
            'attachments.*' => 'الصورة',
        ];
    }

    public function messages(): array
    {
        return [
            'complaint_details.min' => 'يرجى كتابة وصف أوضح قليلًا للحالة.',
            'address_text.min' => 'يرجى كتابة عنوان أو موقع أوضح.',
            'attachments.max' => 'يمكن رفع حتى 5 صور فقط.',
            'attachments.*.image' => 'كل ملف مرفوع يجب أن يكون صورة.',
            'attachments.*.mimes' => 'صيغة الصورة يجب أن تكون JPG أو PNG أو WEBP.',
            'attachments.*.max' => 'حجم الصورة الواحدة يجب ألا يتجاوز 5 ميغابايت.',
        ];
    }
}
