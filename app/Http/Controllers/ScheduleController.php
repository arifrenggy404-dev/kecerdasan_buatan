<?php

namespace App\Http\Controllers;

use App\Models\CourseOffering;
use App\Models\Lecturer;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\TimeSlot;
use App\Services\GeneticAlgorithmService;
use App\Models\ScheduleBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $lecturers = Lecturer::all();
        $rooms = Room::all();
        $offerings = CourseOffering::with(['course', 'lecturer'])->get();
        
        $batches = ScheduleBatch::latest()->get();
        
        $selectedBatchId = $request->query('batch_id');
        $selectedBatch = null;

        if ($selectedBatchId) {
            $selectedBatch = ScheduleBatch::find($selectedBatchId);
        }

        if (!$selectedBatch) {
            $selectedBatch = ScheduleBatch::where('is_published', true)->first() ?? ScheduleBatch::latest()->first();
        }

        $schedules = collect();
        if ($selectedBatch) {
            $schedules = Schedule::where('batch_id', $selectedBatch->id)
                ->with(['courseOffering.course', 'courseOffering.lecturer', 'room', 'day', 'startTimeSlot'])
                ->get()
                ->sortBy(['day_id', 'start_time_slot_id']);
        }

        return view('schedules.index', compact('lecturers', 'rooms', 'offerings', 'schedules', 'batches', 'selectedBatch'));
    }

    public function generate(Request $request, GeneticAlgorithmService $gaService)
    {
        // Validasi ketersediaan data dasar
        $errors = $gaService->checkRequirements();
        if (!empty($errors)) {
            $msg = 'Gagal memulai: ' . implode(' ', $errors);
            if ($request->ajax()) {
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
            $scoredPopulation = $gaService->evolve($population, $i);
            $currentBest = $scoredPopulation[0]['c'];
            $currentFitness = $scoredPopulation[0]['f'];

            if ($currentFitness > $bestFitness) {
                $bestFitness = $currentFitness;
                $bestChromosome = $currentBest;
            }

            $population = $scoredPopulation;
            if ($bestFitness >= 1.0) break;
        }

        // 3. Simpan MUTLAK hanya jika SEMPURNA (Fitness = 1.0 / Nol Bentrok)
        if ($bestChromosome && $bestFitness >= 1.0) {
            $batchId = (string) Str::uuid();
            $generationsCount = $i + 1;

            \Illuminate\Support\Facades\DB::transaction(function() use ($bestChromosome, $gaService, $batchId, $request, $bestFitness, $generationsCount) {
                $draftCount = ScheduleBatch::count() + 1;
                $batchName = $request->name ?: "Draft Jadwal #" . $draftCount;

                ScheduleBatch::create([
                    'id' => $batchId,
                    'name' => $batchName,
                    'fitness' => $bestFitness,
                    'generations' => $generationsCount,
                    'is_published' => ScheduleBatch::count() === 0 // Publish otomatis jika ini batch pertama
                ]);

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

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Draft jadwal baru berhasil dihasilkan!',
                    'batch_id' => $batchId
                ]);
            }

            return redirect()->route('schedules.index', ['batch_id' => $batchId])->with('success', 'Draft jadwal baru berhasil dihasilkan!');
        }

        // 4. JIKA GAGAL
        $penaltyAmount = ($bestFitness > 0) ? (round(1 / $bestFitness) - 1) : 'Banyak';
        $errorMessage = "GAGAL! Sistem tidak menemukan jadwal yang benar-benar bersih. Masih ada {$penaltyAmount} bentrok.";

        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => $errorMessage], 422);
        }

        return redirect()->back()->with('error', $errorMessage);
    }

    public function publish(ScheduleBatch $batch)
    {
        ScheduleBatch::query()->update(['is_published' => false]);
        $batch->update(['is_published' => true]);

        return redirect()->route('schedules.index', ['batch_id' => $batch->id])->with('success', 'Jadwal "' . $batch->name . '" telah dipublikasikan sebagai jadwal utama.');
    }

    public function destroyBatch(ScheduleBatch $batch)
    {
        $batch->delete(); // Cascading delete should handle schedules if configured, otherwise manual:
        Schedule::where('batch_id', $batch->id)->delete();

        return redirect()->route('schedules.index')->with('success', 'Draft jadwal berhasil dihapus.');
    }

    public function destroyAll()
    {
        Schedule::query()->delete();
        ScheduleBatch::query()->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Seluruh data draft jadwal berhasil dihapus.']);
        }

        return redirect()->back()->with('success', 'Seluruh data draft jadwal berhasil dihapus.');
    }

    public function exportCsv(Request $request)
    {
        $batchId = $request->query('batch_id');
        $batch = ScheduleBatch::find($batchId);
        
        $query = Schedule::with(['courseOffering.course', 'courseOffering.lecturer', 'room', 'day', 'startTimeSlot']);
        if ($batchId) {
            $query->where('batch_id', $batchId);
        }

        $schedules = $query->get()->sortBy(['day_id', 'start_time_slot_id']);

        if ($schedules->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada jadwal untuk diekspor.');
        }

        $sksDuration = \App\Models\Setting::getValue('sks_duration', 50);
        $rawFilename = $request->query('filename') ?: ($batch ? $batch->name : "jadwal_perkuliahan_" . date('Y-m-d_H-i'));
        $filename = Str::slug($rawFilename) . ".csv";
        
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

    public function exportPdf(Request $request)
    {
        if (!class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
            return redirect()->back()->with('error', 'Fitur PDF memerlukan package dompdf.');
        }

        $batchId = $request->query('batch_id');
        $batch = ScheduleBatch::find($batchId);

        $query = Schedule::with(['courseOffering.course', 'courseOffering.lecturer', 'room', 'day', 'startTimeSlot']);
        if ($batchId) {
            $query->where('batch_id', $batchId);
        }

        $schedules = $query->get()->sortBy(['day_id', 'start_time_slot_id']);

        if ($schedules->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada jadwal untuk diekspor.');
        }

        $sksDuration = \App\Models\Setting::getValue('sks_duration', 50);
        $rawFilename = $request->query('filename') ?: ($batch ? $batch->name : "jadwal_perkuliahan_" . date('Y-m-d_H-i'));
        $filename = Str::slug($rawFilename) . ".pdf";

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('schedules.pdf', compact('schedules', 'sksDuration'));
        return $pdf->download($filename);
    }
}
