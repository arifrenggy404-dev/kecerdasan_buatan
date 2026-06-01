<?php

namespace App\Http\Controllers;

use App\Models\CourseOffering;
use App\Models\Lecturer;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\TimeSlot;
use App\Services\GeneticAlgorithmService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ScheduleController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::all();
        $rooms = Room::all();
        $offerings = CourseOffering::with(['course', 'lecturer'])->get();
        
        // Ambil semua jadwal (karena kita akan truncate setiap generate baru)
        $schedules = Schedule::with(['courseOffering.course', 'courseOffering.lecturer', 'room', 'day', 'startTimeSlot'])
            ->get()
            ->sortBy(['day_id', 'start_time_slot_id']);

        return view('schedules.index', compact('lecturers', 'rooms', 'offerings', 'schedules'));
    }

    public function generate(GeneticAlgorithmService $gaService)
    {
        // Validasi ketersediaan data dasar
        $errors = $gaService->checkRequirements();
        if (!empty($errors)) {
            $msg = 'Gagal memulai: ' . implode(' ', $errors);
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return redirect()->back()->with('error', $msg);
        }

        // 10 Menit waktu eksekusi maksimal
        set_time_limit(600);

        // 1. Inisialisasi
        $population = $gaService->initializePopulation();
        $maxGenerations = 3000;
        $bestChromosome = null;
        $bestFitness = 0;

        // 2. Evolusi hingga Fitness = 1.0 (MUTLAK NOL BENTROK)
        for ($i = 0; $i < $maxGenerations; $i++) {
            // evolve sekarang menerima index generasi untuk adaptive mutation
            $scoredPopulation = $gaService->evolve($population, $i);
            
            // Ambil yang terbaik dari generasi ini (sudah di-sort oleh evolve)
            $currentBest = $scoredPopulation[0]['c'];
            $currentFitness = $scoredPopulation[0]['f'];

            // Update Best Overall
            if ($currentFitness > $bestFitness) {
                $bestFitness = $currentFitness;
                $bestChromosome = $currentBest;
            }

            // Siapkan populasi untuk generasi berikutnya
            $population = $scoredPopulation;

            // BERHENTI JIKA ZERO PENALTY (1.0)
            if ($bestFitness >= 1.0) {
                break;
            }
        }

        // 3. Simpan MUTLAK hanya jika SEMPURNA (Fitness = 1.0 / Nol Bentrok)
        if ($bestChromosome && $bestFitness >= 1.0) {
            // Gunakan Database Transaction untuk keamanan data
            \Illuminate\Support\Facades\DB::transaction(function() use ($bestChromosome, $gaService) {
                Schedule::query()->delete();

                $batchId = (string) Str::uuid();
                $finalSchedule = $gaService->mapIndicesToIds($bestChromosome);

                foreach ($finalSchedule as $data) {
                    Schedule::create([
                        'course_offering_id' => $data['offering_id'],
                        'room_id'            => $data['room_id'],
                        'day_id'             => $data['day_id'],
                        'start_time_slot_id' => $data['slot_id'],
                        'batch_id'           => $batchId,
                    ]);
                }
            });

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Jadwal SEMPURNA (Nol Bentrok) berhasil dihasilkan dalam ' . ($i + 1) . ' generasi!'
                ]);
            }

            return redirect()->back()->with('success', 'Jadwal SEMPURNA (Nol Bentrok) berhasil dihasilkan dalam ' . ($i + 1) . ' generasi!');
        }

        // 4. JIKA GAGAL (Ada pinalti), JANGAN SIMPAN APAPUN DAN BERI ERROR
        $penaltyAmount = ($bestFitness > 0) ? (round(1 / $bestFitness) - 1) : 'Banyak';
        $errorMessage = "GAGAL! Sistem tidak menemukan jadwal yang benar-benar bersih. Masih ada {$penaltyAmount} bentrok. Data TIDAK disimpan ke database.";

        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 422);
        }

        return redirect()->back()->with('error', $errorMessage . " Silakan coba generate ulang atau tambah kapasitas ruangan/hari.");
        }

    public function destroyAll()
    {
        \App\Models\Schedule::query()->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Seluruh hasil jadwal berhasil dihapus.'
            ]);
        }

        return redirect()->back()->with('success', 'Seluruh hasil jadwal berhasil dihapus.');
    }

    public function exportCsv()
    {
        $schedules = Schedule::with(['courseOffering.course', 'courseOffering.lecturer', 'room', 'day', 'startTimeSlot'])
            ->get()
            ->sortBy(['day_id', 'start_time_slot_id']);

        if ($schedules->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada jadwal untuk diekspor.');
        }

        $sksDuration = \App\Models\Setting::getValue('sks_duration', 50);
        $filename = "jadwal_perkuliahan_" . date('Y-m-d_H-i') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Hari', 'Waktu Mulai', 'Waktu Selesai', 'Mata Kuliah', 'SKS', 'Dosen', 'Gedung', 'Ruangan'];

        $callback = function() use ($schedules, $columns, $sksDuration) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($schedules as $s) {
                $startTimeStr = $s->startTimeSlot?->start_time ?? '00:00';
                $startTime = \Carbon\Carbon::parse($startTimeStr);
                $sks = $s->courseOffering?->sks ?? 0;
                $totalMinutes = $sks * $sksDuration;
                $endTime = $startTime->copy()->addMinutes($totalMinutes);

                fputcsv($file, [
                    $s->day?->name ?? '-',
                    $startTime->format('H:i'),
                    $endTime->format('H:i'),
                    $s->courseOffering?->course?->name ?? '-',
                    $sks,
                    $s->courseOffering?->lecturer?->name ?? '-',
                    $s->room?->building?->name ?? '-',
                    $s->room?->name ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        if (!class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
            return redirect()->back()->with('error', 'Fitur PDF memerlukan package dompdf. Silakan jalankan: composer require barryvdh/laravel-dompdf');
        }

        $schedules = Schedule::with(['courseOffering.course', 'courseOffering.lecturer', 'room', 'day', 'startTimeSlot'])
            ->get()
            ->sortBy(['day_id', 'start_time_slot_id']);

        if ($schedules->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada jadwal untuk diekspor.');
        }

        $sksDuration = \App\Models\Setting::getValue('sks_duration', 50);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('schedules.pdf', compact('schedules', 'sksDuration'));
        return $pdf->download('jadwal_perkuliahan_' . date('Y-m-d_H-i') . '.pdf');
    }
}
