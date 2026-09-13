<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi - {{ $sesi->mata_pelajaran->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            vertical-align: top;
            padding: 3px 0;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
        }
        .stats-box {
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .stats-table {
            width: 100%;
        }
        .stats-table td {
            padding: 3px 0;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th, .data-table td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }
        .data-table th {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .status-hadir {
            color: #166534;
            font-weight: bold;
        }
        .status-tidak {
            color: #991b1b;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>PORTAL LES TKA 2026/2027</h1>
        <h2>REKAPITULASI ABSENSI SESI LES</h2>
    </div>

    @php
        $rombels = $sesi->sesi_les_rombels->pluck('rombel.nama')->implode(', ');
    @endphp

    <table class="info-table">
        <tr>
            <td class="info-label">Tanggal</td>
            <td>: {{ \Carbon\Carbon::parse($sesi->waktu_mulai)->translatedFormat('d F Y') }}</td>
            <td class="info-label">Mata Pelajaran</td>
            <td>: {{ $sesi->mata_pelajaran->nama }}</td>
        </tr>
        <tr>
            <td class="info-label">Waktu</td>
            <td>: {{ $sesi->waktu_mulai ? $sesi->waktu_mulai->format('H:i') : '-' }} - {{ $sesi->waktu_selesai ? $sesi->waktu_selesai->format('H:i') : '-' }}</td>
            <td class="info-label">Guru</td>
            <td>: {{ $sesi->guru->nama_guru }}</td>
        </tr>
        <tr>
            <td class="info-label">Rombel Target</td>
            <td>: {{ $rombels }}</td>
            <td class="info-label">Materi</td>
            <td>: {{ $sesi->materi ?: '-' }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="30%">Nama Siswa</th>
                <th width="15%">NISN</th>
                <th width="15%">Rombel</th>
                <th width="15%" class="text-center">Status</th>
                <th width="20%" class="text-center">Waktu Konfirmasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sesi->absensi_siswas as $index => $absensi)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $absensi->siswa->nama }}</td>
                    <td>{{ $absensi->siswa->nisn }}</td>
                    <td>{{ $absensi->siswa->rombel->nama }}</td>
                    <td class="text-center">
                        @if($absensi->status == 'hadir_valid')
                            <span class="status-hadir">Hadir Valid</span>
                        @elseif($absensi->status == 'menunggu_konfirmasi')
                            <span>Menunggu</span>
                        @elseif($absensi->status == 'sakit')
                            <span>Sakit</span>
                        @elseif($absensi->status == 'izin')
                            <span>Izin</span>
                        @elseif($absensi->status == 'tidak_konfirmasi')
                            <span>Tidak Konfirmasi</span>
                        @elseif($absensi->status == 'tidak_hadir')
                            <span class="status-tidak">Tidak Hadir</span>
                        @else
                            <span>Belum Diabsen</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $absensi->confirmed_at ? \Carbon\Carbon::parse($absensi->confirmed_at)->format('H:i') : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    
    <div class="stats-box">
        <h3 style="margin-top: 0; margin-bottom: 10px; font-size: 14px; text-align: center; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Ringkasan Absensi</h3>
        <table class="stats-table">
            <tr>
                <td width="50%"><strong>Total Siswa Target:</strong> {{ $stats['total_expected'] }}</td>
                <td width="50%"><strong>Hadir Valid:</strong> {{ $stats['hadir_valid'] }}</td>
            </tr>
            <tr>
                <td width="50%"><strong>Sakit:</strong> {{ $stats['sakit'] }}</td>
                <td width="50%"><strong>Izin:</strong> {{ $stats['izin'] }}</td>
            </tr>
            <tr>
                <td width="50%"><strong>Tidak Hadir:</strong> {{ $stats['tidak_hadir'] }}</td>
                <td width="50%"><strong>Tidak Konfirmasi:</strong> {{ $stats['tidak_konfirmasi'] }}</td>
            </tr>
            <tr>
                <td width="50%"><strong>Persentase Kehadiran:</strong> {{ $stats['persentase'] }}%</td>
                <td width="50%"></td>
            </tr>
        </table>
    </div>

</body>
</html>
