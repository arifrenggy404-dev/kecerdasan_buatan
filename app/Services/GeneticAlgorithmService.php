<?php

namespace App\Services;

use App\Models\CourseOffering;
use App\Models\Room;
use App\Models\Day;
use App\Models\TimeSlot;
use App\Models\Setting;

class GeneticAlgorithmService
{
    protected array $offerings;
    protected array $rooms;
    protected array $days;       // Filtered Days
    protected array $timeSlots;  // Filtered TimeSlots
    protected array $slotMinutes; // Pre-calculated minutes [idx => ['start' => min, 'end' => min]]
    protected int $populationSize = 100;
    protected float $mutationRate = 0.05; // Kurangi mutasi agar lebih stabil
    protected int $maxGenerations = 5000;

    public function __construct()
    {
        $this->offerings = CourseOffering::select('id', 'lecturer_id', 'sks', 'type')->get()->toArray();
        $this->rooms = Room::select('id', 'name', 'type')->get()->toArray();
        
        // 1. Ambil batasan dari Setting
        $activeDayIds = Setting::getValue('active_days', [1, 2, 3, 4, 5]);
        $this->days = Day::whereIn('id', $activeDayIds)->orderBy('id')->get()->toArray();
        
        $operational = Setting::getValue('operational_hours', ['start' => '07:00', 'end' => '22:00']);
        $blackouts = Setting::getValue('blackout_hours', []);
        $sksDuration = Setting::getValue('sks_duration', 50);

        // 2. Pastikan tabel time_slots mencukupi rentang operasional dengan durasi SKS yang baru
        $this->ensureTimeSlotsExist($operational['start'], $operational['end'], $sksDuration);

        // 3. Ambil dan filter slot waktu (Hanya yang durasinya pas dengan sks_duration saat ini)
        $this->timeSlots = TimeSlot::orderBy('start_time')
            ->whereTime('start_time', '>=', $operational['start'])
            ->whereTime('end_time', '<=', $operational['end'])
            ->get()
            ->filter(function($slot) use ($blackouts, $sksDuration) {
                $duration = (strtotime($slot->end_time) - strtotime($slot->start_time)) / 60;
                if ($duration != $sksDuration) return false;

                foreach ($blackouts as $b) {
                    if ($slot->start_time >= $b['start'] && $slot->start_time < $b['end']) {
                        return false;
                    }
                }
                return true;
            })
            ->values()
            ->toArray();

        // Pre-calculate minutes for performance
        $this->slotMinutes = [];
        foreach ($this->timeSlots as $idx => $slot) {
            $this->slotMinutes[$idx] = [
                'start' => $this->timeToMinutes($slot['start_time']),
                'end'   => $this->timeToMinutes($slot['end_time'])
            ];
        }
    }

    /**
     * Memeriksa apakah data yang tersedia cukup untuk menjalankan algoritma.
     */
    public function checkRequirements(): array
    {
        $errors = [];
        if (empty($this->offerings)) $errors[] = "Belum ada data Mata Kuliah / Plotting Dosen.";
        if (empty($this->rooms)) $errors[] = "Belum ada data Ruangan.";
        if (empty($this->days)) $errors[] = "Belum ada Hari Kerja yang aktif di Pengaturan.";
        if (empty($this->timeSlots)) $errors[] = "Tidak ada Slot Waktu yang tersedia pada Jam Operasional tersebut.";
        
        return $errors;
    }

    protected function ensureTimeSlotsExist($start, $end, $durationMinutes)
    {
        $startTime = strtotime($start);
        $endTimeLimit = strtotime($end);
        
        while ($startTime < $endTimeLimit) {
            $slotEnd = strtotime('+' . $durationMinutes . ' minutes', $startTime);
            if ($slotEnd > $endTimeLimit) break;

            $startTimeStr = date('H:i:s', $startTime);
            $endTimeStr = date('H:i:s', $slotEnd);

            $exists = TimeSlot::where('start_time', $startTimeStr)
                ->where('end_time', $endTimeStr)
                ->exists();

            if (!$exists) {
                TimeSlot::create([
                    'name' => 'Slot ' . date('H:i', $startTime),
                    'start_time' => $startTimeStr,
                    'end_time' => $endTimeStr
                ]);
            }

            $startTime = strtotime('+10 minutes', $slotEnd);
        }
    }

    public function initializePopulation(): array
    {
        $population = [];
        for ($i = 0; $i < $this->populationSize; $i++) {
            $population[] = $this->generateRandomChromosome();
        }
        return $population;
    }

    protected function generateRandomChromosome(): array
    {
        $chromosome = [];
        $roomsByType = [];
        foreach ($this->rooms as $idx => $room) {
            $roomsByType[$room['type']][] = $idx;
        }

        foreach ($this->offerings as $offering) {
            $sks = $offering['sks'] ?? 3;
            $maxSlotIdx = count($this->timeSlots) - $sks;

            if ($maxSlotIdx < 0) continue; 

            $compatibleRoomIndices = $roomsByType[$offering['type']] ?? array_keys($this->rooms);
            $roomIdx = $compatibleRoomIndices[array_rand($compatibleRoomIndices)];

            $chromosome[] = [
                'offering_id' => $offering['id'],
                'lecturer_id' => $offering['lecturer_id'],
                'offering_type' => $offering['type'],
                'room_idx'    => $roomIdx,
                'day_idx'     => array_rand($this->days), 
                'slot_idx'    => rand(0, $maxSlotIdx),    
                'sks'         => $sks,
            ];
        }
        return $chromosome;
    }

    public function calculateFitness(array $chromosome): float
    {
        $penalty = 0;
        $count = count($chromosome);

        // Pre-calculate data gen dalam bentuk integer menit
        $genesWithMinutes = [];
        foreach ($chromosome as $gene) {
            $startSlotMin = $this->slotMinutes[$gene['slot_idx']];
            $endSlotIdx = $gene['slot_idx'] + $gene['sks'] - 1;
            
            if ($endSlotIdx >= count($this->timeSlots)) {
                $penalty += 1000000;
                $genesWithMinutes[] = null;
                continue;
            }

            $endSlotMin = $this->slotMinutes[$endSlotIdx];

            $genesWithMinutes[] = [
                'lecturer_id' => $gene['lecturer_id'],
                'room_id'     => $this->rooms[$gene['room_idx']]['id'],
                'day_idx'     => $gene['day_idx'],
                'start_min'   => $startSlotMin['start'],
                'end_min'     => $endSlotMin['end'],
                'type'        => $gene['offering_type'],
                'room_type'   => $this->rooms[$gene['room_idx']]['type']
            ];
        }

        for ($i = 0; $i < $count; $i++) {
            $g1 = $genesWithMinutes[$i];
            if (!$g1) continue;

            if ($g1['type'] !== $g1['room_type']) {
                $penalty += 1000000;
            }

            for ($j = $i + 1; $j < $count; $j++) {
                $g2 = $genesWithMinutes[$j];
                if (!$g2) continue;

                if ($g1['day_idx'] === $g2['day_idx']) {
                    $isOverlapping = ($g1['start_min'] < $g2['end_min']) && ($g1['end_min'] > $g2['start_min']);

                    if ($isOverlapping) {
                        if ($g1['lecturer_id'] === $g2['lecturer_id']) {
                            $penalty += 1000000;
                        }

                        if ($g1['room_id'] === $g2['room_id']) {
                            $penalty += 1000000;
                        }
                    }
                }
            }
        }

        return ($penalty === 0) ? 1.0 : (1 / (1 + $penalty));
    }

    protected function timeToMinutes(string $time): int
    {
        $parts = explode(':', $time);
        return ((int)$parts[0] * 60) + (int)$parts[1];
    }

    public function evolve(array $population, int $generationIdx = 0): array
    {
        $scored = [];
        foreach ($population as $p) {
            $chromosome = isset($p['c']) ? $p['c'] : $p;
            $scored[] = ['c' => $chromosome, 'f' => $this->calculateFitness($chromosome)];
        }
        usort($scored, fn($a, $b) => $b['f'] <=> $a['f']);

        $currentMutationRate = $this->mutationRate;
        if ($generationIdx > 500 && $scored[0]['f'] < 1.0) {
            $currentMutationRate = 0.2; 
        }

        $newPopulation = [];
        $elitismCount = max(2, round(count($population) * 0.1));
        for ($i = 0; $i < $elitismCount; $i++) {
            $newPopulation[] = $scored[$i]['c'];
        }

        while (count($newPopulation) < count($population)) {
            $p1 = $this->tournamentSelection($scored);
            $p2 = $this->tournamentSelection($scored);

            $child = $this->crossover($p1, $p2);
            $child = $this->mutate($child, $currentMutationRate);
            $newPopulation[] = $child;
        }

        $finalScored = [];
        foreach ($newPopulation as $c) {
            $finalScored[] = ['c' => $c, 'f' => $this->calculateFitness($c)];
        }
        usort($finalScored, fn($a, $b) => $b['f'] <=> $a['f']);

        return $finalScored;
    }

    protected function tournamentSelection(array $scored): array
    {
        $tournamentSize = 5;
        $best = null;
        for ($i = 0; $i < $tournamentSize; $i++) {
            $idx = rand(0, count($scored) - 1);
            $competitor = $scored[$idx];
            if ($best === null || $competitor['f'] > $best['f']) {
                $best = $competitor;
            }
        }
        return $best['c'];
    }

    public function crossover(array $p1, array $p2): array
    {
        $cp = rand(0, count($p1) - 1);
        $child = [];
        for ($i = 0; $i < count($p1); $i++) {
            $child[$i] = ($i < $cp) ? $p1[$i] : $p2[$i];
        }
        return $child;
    }

    public function mutate(array $chromosome, ?float $overrideRate = null): array
    {
        $rate = $overrideRate ?? $this->mutationRate;
        $roomsByType = [];
        foreach ($this->rooms as $idx => $room) {
            $roomsByType[$room['type']][] = $idx;
        }

        // Safety check
        if (empty($chromosome) || empty($this->days) || empty($this->rooms)) {
            return $chromosome;
        }

        if ((mt_rand() / mt_getrandmax()) < 0.05) {
            $idx1 = array_rand($chromosome);
            $idx2 = array_rand($chromosome);
            
            $tempDay = $chromosome[$idx1]['day_idx'];
            $tempSlot = $chromosome[$idx1]['slot_idx'];
            $tempRoom = $chromosome[$idx1]['room_idx'];
            
            $chromosome[$idx1]['day_idx'] = $chromosome[$idx2]['day_idx'];
            $chromosome[$idx1]['slot_idx'] = $chromosome[$idx2]['slot_idx'];
            $chromosome[$idx1]['room_idx'] = $chromosome[$idx2]['room_idx'];
            
            $chromosome[$idx2]['day_idx'] = $tempDay;
            $chromosome[$idx2]['slot_idx'] = $tempSlot;
            $chromosome[$idx2]['room_idx'] = $tempRoom;
        }

        foreach ($chromosome as &$gene) {
            if ((mt_rand() / mt_getrandmax()) < $rate) {
                $gene['day_idx'] = array_rand($this->days);
                
                $maxSlotIdx = count($this->timeSlots) - $gene['sks'];
                if ($maxSlotIdx >= 0) {
                    $gene['slot_idx'] = rand(0, $maxSlotIdx);
                }

                $compatibleRoomIndices = $roomsByType[$gene['offering_type']] ?? array_keys($this->rooms);
                if (!empty($compatibleRoomIndices)) {
                    $gene['room_idx'] = $compatibleRoomIndices[array_rand($compatibleRoomIndices)];
                }
            }
        }
        return $chromosome;
    }

    public function mapIndicesToIds(array $chromosome): array
    {
        $final = [];
        foreach ($chromosome as $gene) {
            $final[] = [
                'offering_id' => $gene['offering_id'],
                'room_id'     => $this->rooms[$gene['room_idx']]['id'],
                'day_id'      => $this->days[$gene['day_idx']]['id'],
                'slot_id'     => $this->timeSlots[$gene['slot_idx']]['id'],
            ];
        }
        return $final;
    }
}
