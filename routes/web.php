<?php

use App\Http\Controllers\PublicReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicReportController::class, 'create'])->name('public.reports.create');
Route::get('/report', [PublicReportController::class, 'create'])->name('public.reports.form');
Route::post('/reports', [PublicReportController::class, 'store'])->name('public.reports.store');
Route::get('/reports/success/{trackingCode}', [PublicReportController::class, 'success'])->name('public.reports.success');
Route::get('/districts/{district}/neighborhoods', [PublicReportController::class, 'neighborhoods'])
    ->whereNumber('district')
    ->name('public.districts.neighborhoods');
