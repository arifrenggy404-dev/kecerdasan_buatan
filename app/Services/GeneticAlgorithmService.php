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
    protected array $timeSlots;  // All possible TimeSlots within operational hours
    protected array $slotMinutes; // Pre-calculated minutes [idx => ['start' => min, 'end' => min]]
    protected array $blackouts;   // Day-specific blackouts
    protected int $populationSize = 100;
    protected float $mutationRate = 0.05;
    protected int $maxGenerations = 5000;

    protected array $blackoutMinutes; // Pre-calculated blackout minutes

    public function __construct()
    {
        $this->offerings = CourseOffering::select('id', 'lecturer_id', 'sks', 'type')->get()->toArray();
        $this->rooms = Room::select('id', 'name', 'type')->get()->toArray();
        
        $activeDayIds = Setting::getValue('active_days', [1, 2, 3, 4, 5]);
        $this->days = Day::whereIn('id', $activeDayIds)->orderBy('id')->get()->toArray();
        
        $operational = Setting::getValue('operational_hours', ['start' => '07:00', 'end' => '22:00']);
        $this->blackouts = Setting::getValue('blackout_hours', []);
        $sksDuration = Setting::getValue('sks_duration', 50);

        // Pre-calculate blackout minutes
        $this->blackoutMinutes = [];
        foreach ($this->blackouts as $b) {
            $this->blackoutMinutes[] = [
                'day_id' => $b['day_id'],
                'start'  => $this->timeToMinutes($b['start']),
                'end'    => $this->timeToMinutes($b['end']),
            ];
        }

        $this->ensureTimeSlotsExist($operational['start'], $operational['end'], $sksDuration);

        $this->timeSlots = TimeSlot::orderBy('start_time')
            ->whereTime('start_time', '>=', $operational['start'])
            ->whereTime('end_time', '<=', $operational['end'])
            ->get()
            ->filter(function($slot) use ($sksDuration) {
                $duration = (strtotime($slot->end_time) - strtotime($slot->start_time)) / 60;
                return $duration == $sksDuration;
            })
            ->values()
            ->toArray();

        $this->slotMinutes = [];
        foreach ($this->timeSlots as $idx => $slot) {
            $this->slotMinutes[$idx] = [
                'start' => $this->timeToMinutes($slot['start_time']),
                'end'   => $this->timeToMinutes($slot['end_time'])
            ];
        }
    }

    protected function isBlackout($dayId, $slotIdx, $sks): bool
    {
        $endSlotIdx = $slotIdx + $sks - 1;
        if (!isset($this->slotMinutes[$slotIdx]) || !isset($this->slotMinutes[$endSlotIdx])) {
            return true;
        }

        $classStart = $this->slotMinutes[$slotIdx]['start'];
        $classEnd = $this->slotMinutes[$endSlotIdx]['end'];

        foreach ($this->blackoutMinutes as $b) {
            if ($b['day_id'] != 0 && $b['day_id'] != $dayId) continue;

            // Overlap check: (StartA < EndB) and (EndA > StartB)
            if ($classStart < $b['end'] && $classEnd > $b['start']) {
                return true;
            }
        }
        return false;
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

            $startTime = $slotEnd;
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

            // Try to find a non-blackout slot
            $dayIdx = array_rand($this->days);
            $slotIdx = rand(0, $maxSlotIdx);
            
            // Retry up to 10 times to find a non-blackout slot
            for ($retry = 0; $retry < 10; $retry++) {
                if (!$this->isBlackout($this->days[$dayIdx]['id'], $slotIdx, $sks)) {
                    break;
                }
                $dayIdx = array_rand($this->days);
                $slotIdx = rand(0, $maxSlotIdx);
            }

            $chromosome[] = [
                'offering_id' => $offering['id'],
                'lecturer_id' => $offering['lecturer_id'],
                'offering_type' => $offering['type'],
                'room_idx'    => $roomIdx,
                'day_idx'     => $dayIdx, 
                'slot_idx'    => $slotIdx,    
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

            // Check for blackout
            if ($this->isBlackout($this->days[$gene['day_idx']]['id'], $gene['slot_idx'], $gene['sks'])) {
                $penalty += 1000000;
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
                $maxSlotIdx = count($this->timeSlots) - $gene['sks'];
                if ($maxSlotIdx >= 0) {
                    $newDayIdx = array_rand($this->days);
                    $newSlotIdx = rand(0, $maxSlotIdx);

                    // Try to avoid blackout
                    for ($retry = 0; $retry < 5; $retry++) {
                        if (!$this->isBlackout($this->days[$newDayIdx]['id'], $newSlotIdx, $gene['sks'])) {
                            break;
                        }
                        $newDayIdx = array_rand($this->days);
                        $newSlotIdx = rand(0, $maxSlotIdx);
                    }

                    $gene['day_idx'] = $newDayIdx;
                    $gene['slot_idx'] = $newSlotIdx;
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
