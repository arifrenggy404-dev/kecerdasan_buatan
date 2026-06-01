<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Perkuliahan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 30px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Hasil Penjadwalan Perkuliahan Otomatis</h2>
        <p>Dicetak pada: {{ date('d-m-Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Hari</th>
                <th>Waktu</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $s)
                @php
                    $startTimeStr = $s->startTimeSlot?->start_time ?? '00:00';
                    $startTime = \Carbon\Carbon::parse($startTimeStr);
                    $sks = $s->courseOffering?->sks ?? 0;
                    $totalMinutes = $sks * $sksDuration;
                    $endTime = $startTime->copy()->addMinutes($totalMinutes);
                @endphp
                <tr>
                    <td>{{ $s->day?->name }}</td>
                    <td>{{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }}</td>
                    <td>
                        <strong>{{ $s->courseOffering?->course?->name }}</strong><br>
                        <small>{{ $sks }} SKS</small>
                    </td>
                    <td>{{ $s->courseOffering?->lecturer?->name }}</td>
                    <td>{{ $s->room?->building?->name }} | {{ $s->room?->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Halaman 1 dari 1 - Sistem Penjadwalan Algoritma Genetika
    </div>
</body>
</html>
