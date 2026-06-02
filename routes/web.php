<?php

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ScheduleController::class, 'index'])->name('schedules.index');
Route::post('/generate', [ScheduleController::class, 'generate'])->name('schedules.generate');
Route::delete('/schedules/clear', [ScheduleController::class, 'destroyAll'])->name('schedules.clear');
Route::get('/schedules/export/csv', [ScheduleController::class, 'exportCSV'])->name('schedules.export.csv');
Route::get('/schedules/export/pdf', [ScheduleController::class, 'exportPDF'])->name('schedules.export.pdf');

// Documentation Routes
Route::prefix('docs')->group(function () {
    Route::get('/', [DocumentationController::class, 'index'])->name('docs.index');
    Route::get('/usage', [DocumentationController::class, 'usage'])->name('docs.usage');
    Route::get('/algorithm', [DocumentationController::class, 'algorithm'])->name('docs.algorithm');
    Route::get('/architecture', [DocumentationController::class, 'architecture'])->name('docs.architecture');
    Route::get('/troubleshooting', [DocumentationController::class, 'troubleshooting'])->name('docs.troubleshooting');
    Route::get('/export', [DocumentationController::class, 'export'])->name('docs.export');
    Route::get('/faq', [DocumentationController::class, 'faq'])->name('docs.faq');
});

Route::resource('lecturers', LecturerController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('buildings', BuildingController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('rooms', RoomController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('courses', CourseController::class)->only(['index', 'store', 'update', 'destroy']);
Route::put('course-offerings/{offering}', [CourseController::class, 'updateOffering'])->name('course-offerings.update');
Route::delete('course-offerings/{offering}', [CourseController::class, 'destroyOffering'])->name('course-offerings.destroy');

Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
