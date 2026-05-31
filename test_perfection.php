<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\GeneticAlgorithmService;

// Mock Service untuk testing High Load (Tanpa merusak database)
class PerfectionTestService extends GeneticAlgorithmService {
    public function setMockOfferings($count) {
        $this->offerings = [];
        for ($i = 1; $i <= $count; $i++) {
            $this->offerings[] = [
                'id' => $i,
                'lecturer_id' => rand(1, 10), // 10 Dosen berbeda
                'sks' => rand(2, 4),         // SKS variatif 2-4
                'type' => (rand(0, 10) > 8) ? 'lab' : 'theory' // 20% Lab
            ];
        }
    }
}

$service = new PerfectionTestService();
$load = 50; // Beban tinggi (2x lipat data sekarang)
$service->setMockOfferings($load);

echo "Starting Perfection Stress Test (High Load: $load Offerings)...\n";
echo "Constraint: Absolute Zero Conflict\n\n";

$population = $service->initializePopulation();
$maxGenerations = 3000;
$bestFitness = 0;

$startTime = microtime(true);

for ($i = 0; $i < $maxGenerations; $i++) {
    $scoredPopulation = $service->evolve($population, $i);
    $currentFitness = $scoredPopulation[0]['f'];
    
    if ($currentFitness > $bestFitness) {
        $bestFitness = $currentFitness;
        echo "Gen " . ($i + 1) . ": Fitness = " . $bestFitness . "\n";
    }

    $population = $scoredPopulation;

    if ($bestFitness >= 1.0) {
        $endTime = microtime(true);
        $duration = round($endTime - $startTime, 2);
        echo "\nPERFECTION REACHED! Zero conflicts found at Gen " . ($i + 1) . "\n";
        echo "Execution Time: $duration seconds\n";
        break;
    }
}

if ($bestFitness < 1.0) {
    echo "\nFAILED to reach perfection at high load.\n";
}
