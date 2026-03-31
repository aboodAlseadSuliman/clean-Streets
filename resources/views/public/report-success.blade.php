@extends('layouts.public')

@section('title', 'تم استلام البلاغ')

@section('content')
    <main class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 hero-pattern opacity-90"></div>

        <section class="relative mx-auto flex min-h-screen max-w-4xl items-center px-4 py-10 sm:px-6 lg:px-8">
            <div class="glass-card w-full overflow-hidden p-8 sm:p-10">
                <div class="mx-auto flex max-w-2xl flex-col items-center text-center">
                    <div class="flex h-20 w-20 items-center justify-center rounded-[2rem] bg-emerald-900 text-3xl font-extrabold text-white shadow-xl shadow-emerald-950/25">
                        تم
                    </div>

                    <p class="section-kicker mt-6">نجاح الإرسال</p>
                    <h1 class="mt-3 text-4xl leading-tight font-extrabold text-slate-950 sm:text-5xl">
                        تم استلام البلاغ بنجاح
                    </h1>

                    <p class="mt-5 max-w-xl text-lg leading-8 text-slate-700">
                        سيُراجع البلاغ من قبل الجهة المختصة، وقد يتم التواصل معك عند الحاجة إلى معلومات
                        إضافية.
                    </p>

                    <div class="mt-8 w-full rounded-[2rem] border border-amber-200 bg-amber-50 px-6 py-5">
                        <p class="text-sm font-bold uppercase tracking-[0.3em] text-amber-900/70">Tracking Code</p>
                        <p class="mt-3 text-3xl font-extrabold tracking-[0.15em] text-slate-950">
                            {{ $trackingCode }}
                        </p>
                    </div>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('public.reports.create') }}" class="primary-button">
                            إرسال بلاغ جديد
                        </a>

                        <button
                            type="button"
                            class="secondary-button"
                            onclick="navigator.clipboard && navigator.clipboard.writeText('{{ $trackingCode }}')"
                        >
                            نسخ رقم التتبع
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
