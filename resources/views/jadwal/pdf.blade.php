<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Perkuliahan</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; table-layout: fixed; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; word-wrap: break-word; }
        th { background-color: #f8f9fa; color: #555; font-weight: bold; text-transform: uppercase; font-size: 9px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #000; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #666; }
        .semester-header { background-color: #e9ecef; padding: 8px 12px; font-weight: bold; border: 1px solid #ccc; border-bottom: none; color: #0d6efd; font-size: 13px; }
        .footer { position: fixed; bottom: -20px; left: 0; right: 0; height: 30px; text-align: center; font-size: 9px; color: #999; border-top: 1px solid #eee; padding-top: 5px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Hasil Penjadwalan Kuliah</h2>
        <p>Sistem Optimasi Algoritma Genetika | Dicetak: {{ date('d-m-Y H:i') }}</p>
    </div>

    @foreach($jadwalTerkelompok as $semester => $semesterSchedules)
        <div class="semester-header">
            SEMESTER {{ $semester }}
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 12%;">Hari</th>
                    <th style="width: 18%;">Waktu</th>
                    <th style="width: 30%;">Mata Kuliah</th>
                    <th style="width: 25%;">Dosen</th>
                    <th style="width: 15%;">Ruangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($semesterSchedules as $s)
                    @php
                        $startTimeStr = $s->slotWaktuMulai?->jam_mulai ?? '00:00';
                        $startTime = \Carbon\Carbon::parse($startTimeStr);
                        $sks = $s->kelas?->sks ?? 0;
                        $totalMinutes = $sks * $durasiSks;
                        $endTime = $startTime->copy()->addMinutes($totalMinutes);
                    @endphp
                    <tr>
                        <td>{{ $s->hari?->nama }}</td>
                        <td>{{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }}</td>
                        <td>
                            <strong>{{ $s->kelas?->mataKuliah?->nama }}</strong><br>
                            <span style="font-size: 8px; color: #777;">{{ $sks }} SKS</span>
                        </td>
                        <td>{{ $s->kelas?->dosen?->nama }}</td>
                        <td>
                            {{ $s->ruangan?->nama }}<br>
                            <span style="font-size: 8px; color: #777;">{{ $s->ruangan?->gedung?->nama }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if(!$loop->last)
            {{-- Optional: page-break after each semester if you want --}}
            {{-- <div class="page-break"></div> --}}
        @endif
    @endforeach

    <div class="footer">
        Dicetak otomatis oleh Sistem Penjadwalan AI - Halaman 1
    </div>
</body>
</html>
