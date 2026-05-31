<?php

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ScheduleController::class, 'index'])->name('schedules.index');
Route::post('/generate', [ScheduleController::class, 'generate'])->name('schedules.generate');
Route::delete('/schedules/clear', [ScheduleController::class, 'destroyAll'])->name('schedules.clear');

Route::resource('lecturers', LecturerController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('buildings', BuildingController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('rooms', RoomController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('courses', CourseController::class)->only(['index', 'store', 'update', 'destroy']);
Route::put('course-offerings/{offering}', [CourseController::class, 'updateOffering'])->name('course-offerings.update');
Route::delete('course-offerings/{offering}', [CourseController::class, 'destroyOffering'])->name('course-offerings.destroy');

Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
