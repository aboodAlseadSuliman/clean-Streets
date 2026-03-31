@extends('layouts.public')

@section('title', 'تقديم بلاغ مواطن')

@php
    $selectedDistrict = old('district_id');
@endphp

@section('content')
    <main class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 hero-pattern opacity-90"></div>

        <section class="relative mx-auto flex min-h-screen w-full max-w-7xl flex-col px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid flex-1 gap-6 lg:grid-cols-[0.95fr_1.05fr] lg:gap-10">
                <div class="space-y-6">
                    <div class="glass-card overflow-hidden p-6 sm:p-8">
                        <div class="inline-flex items-center gap-2 rounded-full bg-emerald-950/90 px-4 py-2 text-sm font-bold text-white shadow-lg shadow-emerald-950/20">
                            <span class="inline-block h-2.5 w-2.5 rounded-full bg-amber-300"></span>
                            منصة تنظيف الشوارع ومتابعة البلاغات
                        </div>

                        <div class="mt-6 space-y-5">
                            <p class="text-sm font-bold uppercase tracking-[0.3em] text-emerald-900/60">
                                Homs Clean Streets
                            </p>
                            <h1 class="max-w-xl text-4xl leading-tight font-extrabold text-slate-950 sm:text-5xl">
                                بلّغ عن سيارة متضررة أو محروقة وسنحوّل البلاغ للجهة المعنية
                            </h1>
                            <p class="max-w-2xl text-lg leading-8 text-slate-700">
                                هذه الصفحة مخصّصة لاستقبال بلاغات المواطنين حول هياكل السيارات أو السيارات
                                المتضررة التي تعيق الطريق أو تشوّه المشهد العام. املأ المعلومات بدقة وأرفق
                                صورًا واضحة إن أمكن.
                            </p>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            <div class="feature-card">
                                <div class="feature-badge">1</div>
                                <h2 class="mt-4 text-lg font-extrabold text-slate-900">أرسل البلاغ</h2>
                                <p class="mt-2 text-sm leading-7 text-slate-600">
                                    أضف العنوان، وصف السيارة، الصور، ورابط خرائط Google إن توفر.
                                </p>
                            </div>

                            <div class="feature-card">
                                <div class="feature-badge">2</div>
                                <h2 class="mt-4 text-lg font-extrabold text-slate-900">نراجع الطلب</h2>
                                <p class="mt-2 text-sm leading-7 text-slate-600">
                                    يتم تدقيق البلاغ داخليًا وربطه بحالة موجودة أو إنشاء حالة جديدة.
                                </p>
                            </div>

                            <div class="feature-card">
                                <div class="feature-badge">3</div>
                                <h2 class="mt-4 text-lg font-extrabold text-slate-900">نحوّله للجهة</h2>
                                <p class="mt-2 text-sm leading-7 text-slate-600">
                                    البلدية أو المرور أو الجهة المختصة تتابع الحالة حتى الإزالة أو الإغلاق.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card p-6 sm:p-8">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="section-kicker">قبل الإرسال</p>
                                <h2 class="mt-2 text-2xl font-extrabold text-slate-950">ما الذي يساعدنا أكثر؟</h2>
                            </div>
                            <div class="status-chip">الخدمة مجانية</div>
                        </div>

                        <div class="mt-6 grid gap-4 sm:grid-cols-2">
                            <div class="info-tile">
                                <h3 class="font-bold text-slate-900">صورة واضحة</h3>
                                <p class="mt-2 text-sm leading-7 text-slate-600">
                                    صورة من الأمام أو الجنب تساعد في تمييز السيارة والضرر بشكل أسرع.
                                </p>
                            </div>

                            <div class="info-tile">
                                <h3 class="font-bold text-slate-900">عنوان دقيق</h3>
                                <p class="mt-2 text-sm leading-7 text-slate-600">
                                    اكتب الشارع أو أقرب معلم، ويمكنك إضافة رابط موقع من خرائط Google.
                                </p>
                            </div>

                            <div class="info-tile">
                                <h3 class="font-bold text-slate-900">بيانات تواصل صحيحة</h3>
                                <p class="mt-2 text-sm leading-7 text-slate-600">
                                    قد تحتاج الجهة المختصة إلى التواصل للاستفسار أو تأكيد الموقع.
                                </p>
                            </div>

                            <div class="info-tile">
                                <h3 class="font-bold text-slate-900">وصف مختصر وواضح</h3>
                                <p class="mt-2 text-sm leading-7 text-slate-600">
                                    اذكر إن كانت السيارة محروقة، مدمرة، تسد الطريق، أو متروكة منذ مدة.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-card form-panel p-6 sm:p-8">
                    <div class="mb-6 flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <p class="section-kicker">فورم المواطن</p>
                            <h2 class="mt-2 text-3xl font-extrabold text-slate-950">إرسال بلاغ جديد</h2>
                            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">
                                الحقول التي تحمل علامة <span class="font-extrabold text-rose-700">*</span> مطلوبة.
                            </p>
                        </div>

                        <div class="status-chip status-chip-soft">
                            يتم إنشاء رقم تتبع تلقائي بعد الإرسال
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 rounded-3xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800 shadow-sm">
                            <p class="font-extrabold">يرجى مراجعة الحقول التالية:</p>
                            <ul class="mt-3 list-disc space-y-1 pr-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('public.reports.store') }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <section class="space-y-5">
                            <div class="section-heading">
                                <div class="section-icon">أ</div>
                                <div>
                                    <h3 class="text-xl font-extrabold text-slate-950">بيانات التواصل</h3>
                                    <p class="mt-1 text-sm text-slate-600">هذه المعلومات تساعدنا على المتابعة عند الحاجة.</p>
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="field-label" for="full_name">الاسم الكامل *</label>
                                    <input class="field-input" id="full_name" name="full_name" type="text" value="{{ old('full_name') }}" required>
                                </div>

                                <div>
                                    <label class="field-label" for="phone">رقم الهاتف *</label>
                                    <input class="field-input" id="phone" name="phone" type="text" value="{{ old('phone') }}" required>
                                </div>

                                <div>
                                    <label class="field-label" for="whatsapp_phone">رقم الواتساب</label>
                                    <input class="field-input" id="whatsapp_phone" name="whatsapp_phone" type="text" value="{{ old('whatsapp_phone') }}">
                                </div>

                                <div>
                                    <label class="field-label" for="email">البريد الإلكتروني</label>
                                    <input class="field-input" id="email" name="email" type="email" value="{{ old('email') }}">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="field-label" for="preferred_contact_method">وسيلة التواصل المفضلة</label>
                                    <select class="field-input" id="preferred_contact_method" name="preferred_contact_method">
                                        <option value="">اختر وسيلة التواصل</option>
                                        @foreach ($contactMethods as $value => $label)
                                            <option value="{{ $value }}" @selected(old('preferred_contact_method') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </section>

                        <section class="space-y-5">
                            <div class="section-heading">
                                <div class="section-icon">ب</div>
                                <div>
                                    <h3 class="text-xl font-extrabold text-slate-950">موقع السيارة</h3>
                                    <p class="mt-1 text-sm text-slate-600">كلما كان الموقع أوضح، كانت المعالجة أسرع.</p>
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="field-label" for="district_id">المنطقة</label>
                                    <select class="field-input" id="district_id" name="district_id">
                                        <option value="">اختر المنطقة</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}" @selected((string) old('district_id') === (string) $district->id)>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($districts->isEmpty())
                                        <p class="field-help">لم تتم إضافة المناطق بعد في لوحة الإدارة، لكن يمكنك متابعة الإرسال باستخدام العنوان النصي.</p>
                                    @endif
                                </div>

                                <div>
                                    <label class="field-label" for="neighborhood_id">الحي</label>
                                    <select
                                        class="field-input"
                                        id="neighborhood_id"
                                        name="neighborhood_id"
                                        data-route-template="{{ route('public.districts.neighborhoods', ['district' => '__DISTRICT__']) }}"
                                        data-selected="{{ old('neighborhood_id') }}"
                                    >
                                        <option value="">اختر الحي</option>
                                    </select>
                                    <p class="field-help">سيتم تحميل الأحياء بعد اختيار المنطقة.</p>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="field-label" for="address_text">العنوان أو وصف الموقع *</label>
                                    <textarea class="field-input min-h-28" id="address_text" name="address_text" required>{{ trim(old('address_text', '')) }}</textarea>
                                </div>

                                <div>
                                    <label class="field-label" for="nearest_landmark">أقرب معلم</label>
                                    <input class="field-input" id="nearest_landmark" name="nearest_landmark" type="text" value="{{ old('nearest_landmark') }}">
                                </div>

                                <div>
                                    <label class="field-label" for="google_maps_url">رابط خرائط Google</label>
                                    <input
                                        class="field-input"
                                        id="google_maps_url"
                                        name="google_maps_url"
                                        type="url"
                                        value="{{ old('google_maps_url') }}"
                                        placeholder="https://maps.google.com/..."
                                    >
                                </div>

                                <div>
                                    <label class="field-label" for="latitude">خط العرض Latitude</label>
                                    <input class="field-input" id="latitude" name="latitude" type="text" value="{{ old('latitude') }}">
                                </div>

                                <div>
                                    <label class="field-label" for="longitude">خط الطول Longitude</label>
                                    <input class="field-input" id="longitude" name="longitude" type="text" value="{{ old('longitude') }}">
                                </div>
                            </div>
                        </section>

                        <section class="space-y-5">
                            <div class="section-heading">
                                <div class="section-icon">ج</div>
                                <div>
                                    <h3 class="text-xl font-extrabold text-slate-950">وصف السيارة والشكوى</h3>
                                    <p class="mt-1 text-sm text-slate-600">أدخل ما تعرفه، واترك غير المتوفر فارغًا.</p>
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label class="field-label" for="subject">عنوان البلاغ</label>
                                    <input class="field-input" id="subject" name="subject" type="text" value="{{ old('subject') }}" placeholder="مثال: سيارة محروقة قرب الساحة">
                                </div>

                                <div>
                                    <label class="field-label" for="vehicle_type">نوع السيارة</label>
                                    <select class="field-input" id="vehicle_type" name="vehicle_type">
                                        <option value="">اختر النوع</option>
                                        @foreach ($vehicleTypes as $value => $label)
                                            <option value="{{ $value }}" @selected(old('vehicle_type') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="field-label" for="damage_type">حالة السيارة</label>
                                    <select class="field-input" id="damage_type" name="damage_type">
                                        <option value="">اختر الحالة</option>
                                        @foreach ($damageTypes as $value => $label)
                                            <option value="{{ $value }}" @selected(old('damage_type') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="field-label" for="plate_number">رقم اللوحة</label>
                                    <input class="field-input" id="plate_number" name="plate_number" type="text" value="{{ old('plate_number') }}">
                                </div>

                                <div>
                                    <label class="field-label" for="color">لون السيارة</label>
                                    <input class="field-input" id="color" name="color" type="text" value="{{ old('color') }}">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="field-label" for="make_model">الماركة أو الموديل</label>
                                    <input class="field-input" id="make_model" name="make_model" type="text" value="{{ old('make_model') }}">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="field-label" for="complaint_details">تفاصيل الشكوى *</label>
                                    <textarea
                                        class="field-input min-h-36"
                                        id="complaint_details"
                                        name="complaint_details"
                                        required
                                        placeholder="اكتب وصفًا واضحًا للحالة: هل السيارة محروقة؟ هل تعيق الطريق؟ منذ متى هي موجودة؟"
                                    >{{ trim(old('complaint_details', '')) }}</textarea>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="field-label" for="attachments">صور السيارة</label>
                                    <input class="field-input file-input" id="attachments" name="attachments[]" type="file" accept=".jpg,.jpeg,.png,.webp,image/*" multiple>
                                    <div class="mt-2 flex flex-wrap items-center justify-between gap-3">
                                        <p class="field-help">يمكنك رفع حتى 5 صور، بحد أقصى 5 ميغابايت للصورة الواحدة.</p>
                                        <p class="text-sm font-bold text-emerald-900" id="attachments-feedback">لم يتم اختيار صور بعد</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <div class="rounded-3xl border border-emerald-100 bg-emerald-50/70 px-5 py-4 text-sm leading-7 text-emerald-900">
                            بعد الإرسال سيظهر لك رقم تتبع خاص بالبلاغ. احتفظ به لاستخدامه في المتابعة لاحقًا.
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ route('public.reports.create') }}" class="secondary-button">
                                إعادة ضبط الفورم
                            </a>

                            <button type="submit" class="primary-button">
                                إرسال البلاغ الآن
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const districtSelect = document.getElementById('district_id');
            const neighborhoodSelect = document.getElementById('neighborhood_id');
            const selectedNeighborhood = neighborhoodSelect?.dataset.selected || '';
            const attachmentsInput = document.getElementById('attachments');
            const attachmentsFeedback = document.getElementById('attachments-feedback');

            const setNeighborhoodOptions = (items) => {
                neighborhoodSelect.innerHTML = '<option value="">اختر الحي</option>';

                items.forEach((item) => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;

                    if (String(item.id) === String(selectedNeighborhood)) {
                        option.selected = true;
                    }

                    neighborhoodSelect.appendChild(option);
                });
            };

            const loadNeighborhoods = async () => {
                const districtId = districtSelect.value;

                neighborhoodSelect.innerHTML = '<option value="">جارٍ تحميل الأحياء...</option>';

                if (!districtId) {
                    neighborhoodSelect.innerHTML = '<option value="">اختر الحي</option>';
                    return;
                }

                try {
                    const url = neighborhoodSelect.dataset.routeTemplate.replace('__DISTRICT__', districtId);
                    const response = await fetch(url, {
                        headers: {
                            Accept: 'application/json',
                        },
                    });

                    const payload = await response.json();
                    setNeighborhoodOptions(payload.data || []);
                } catch (error) {
                    neighborhoodSelect.innerHTML = '<option value="">تعذر تحميل الأحياء</option>';
                }
            };

            districtSelect?.addEventListener('change', () => {
                neighborhoodSelect.dataset.selected = '';
                loadNeighborhoods();
            });

            if (districtSelect?.value) {
                loadNeighborhoods();
            }

            attachmentsInput?.addEventListener('change', () => {
                const count = attachmentsInput.files?.length || 0;

                attachmentsFeedback.textContent = count
                    ? `تم اختيار ${count} صورة`
                    : 'لم يتم اختيار صور بعد';
            });
        });
    </script>
@endpush
