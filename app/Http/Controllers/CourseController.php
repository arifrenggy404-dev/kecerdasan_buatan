<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseOffering;
use App\Models\Lecturer;
use App\Models\Room;
use App\Http\Requests\StoreCourseRequest;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('offerings.lecturer', 'offerings.room.building')->get();
        $lecturers = Lecturer::all();
        $rooms = Room::with('building')->get();
        return view('courses.index', compact('courses', 'lecturers', 'rooms'));
    }

    public function store(StoreCourseRequest $request)
    {
        DB::transaction(function () use ($request) {
            $courseId = $request->course_id;

            // Jika tidak pilih dari dropdown, coba cari berdasarkan Kode MK yang diinput manual
            if (!$courseId && $request->code) {
                $existingCourse = Course::where('code', $request->code)->first();
                if ($existingCourse) {
                    $courseId = $existingCourse->id;
                }
            }

            if (!$courseId) {
                $course = Course::create([
                    'name' => $request->name,
                    'code' => $request->code,
                    'sks' => $request->sks,
                    'type' => $request->type,
                ]);
                $courseId = $course->id;
            }

            CourseOffering::create([
                'course_id' => $courseId,
                'lecturer_id' => $request->lecturer_id,
                'sks' => $request->sks,
                'type' => $request->type,
                'name' => $request->name_offering, // Bisa null jika tidak diinput
            ]);
        });

        return redirect()->back()->with('success', 'Plotting Mata Kuliah berhasil disimpan.');
    }

    public function update(StoreCourseRequest $request, Course $course)
    {
        $course->update([
            'name' => $request->name,
            'code' => $request->code,
            'sks' => $request->sks,
            'type' => $request->type,
        ]);
        return redirect()->back()->with('success', 'Mata Kuliah berhasil diperbarui.');
    }

    public function updateOffering(StoreCourseRequest $request, CourseOffering $offering)
    {
        $offering->update([
            'lecturer_id' => $request->lecturer_id,
            'sks' => $request->sks,
            'type' => $request->type,
        ]);
        return redirect()->back()->with('success', 'Plotting berhasil diperbarui.');
    }

    public function destroyOffering(CourseOffering $offering)
    {
        $course = $offering->course;
        $offering->delete();

        // Jika tidak ada offering lagi, hapus matkulnya sekalian agar bersih
        if ($course->offerings()->count() === 0) {
            $course->delete();
        }

        return redirect()->back()->with('success', 'Plotting berhasil dihapus.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->back()->with('success', 'Mata Kuliah beserta seluruh plottingnya berhasil dihapus.');
    }
}
