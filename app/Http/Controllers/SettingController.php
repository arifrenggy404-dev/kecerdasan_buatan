<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Setting;
use App\Http\Requests\UpdateSettingRequest;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $allDays = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];

        $activeDays = Setting::getValue('active_days', [1, 2, 3, 4, 5]);
        $operationalHours = Setting::getValue('operational_hours', ['start' => '07:30', 'end' => '17:00']);
        $blackoutHours = Setting::getValue('blackout_hours', [['start' => '12:00', 'end' => '13:00']]);
        $sksDuration = Setting::getValue('sks_duration', 50);

        return view('settings.index', compact('allDays', 'activeDays', 'operationalHours', 'blackoutHours', 'sksDuration'));
    }

    public function update(UpdateSettingRequest $request)
    {
        $allDays = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];

        $activeDayIds = $request->active_days ?? [];
        
        // Pastikan setiap hari yang diaktifkan ada di database
        foreach ($activeDayIds as $id) {
            if (isset($allDays[$id])) {
                Day::firstOrCreate(
                    ['id' => $id],
                    ['name' => $allDays[$id]]
                );
            }
        }

        Setting::setValue('active_days', array_map('intval', $activeDayIds));
        Setting::setValue('sks_duration', (int) $request->sks_duration);
        
        Setting::setValue('operational_hours', [
            'start' => $request->operational_start,
            'end' => $request->operational_end,
        ]);

        $blackout = [];
        if ($request->blackout_start && $request->blackout_end) {
            $blackout[] = [
                'start' => $request->blackout_start,
                'end' => $request->blackout_end,
            ];
        }
        Setting::setValue('blackout_hours', $blackout);

        return redirect()->back()->with('success', 'Pengaturan batasan waktu berhasil diperbarui.');
    }
}
