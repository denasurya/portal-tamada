<?php

namespace App\Exports;

use App\Models\SesiLes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiSesiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithCustomStartCell, WithEvents
{
    protected $sesi;
    protected $stats;

    public function __construct(SesiLes $sesi)
    {
        $this->sesi = $sesi;
        $this->sesi->load(['mata_pelajaran', 'guru', 'absensi_siswas.siswa.rombel', 'sesi_les_rombels.rombel']);
        $this->stats = $sesi->getAbsensiStats();
    }

    public function collection()
    {
        return $this->sesi->absensi_siswas;
    }

    public function startCell(): string
    {
        return 'A11';
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'NISN',
            'Rombel',
            'Status Kehadiran',
            'Waktu Konfirmasi'
        ];
    }

    public function map($absensi): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        $statusLabel = 'Belum Diabsen';
        if ($absensi->status == 'hadir_valid') $statusLabel = 'Hadir Valid';
        elseif ($absensi->status == 'menunggu_konfirmasi') $statusLabel = 'Menunggu Konfirmasi';
        elseif ($absensi->status == 'sakit') $statusLabel = 'Sakit';
        elseif ($absensi->status == 'izin') $statusLabel = 'Izin';
        elseif ($absensi->status == 'tidak_konfirmasi') $statusLabel = 'Tidak Konfirmasi';
        elseif ($absensi->status == 'tidak_hadir') $statusLabel = 'Tidak Hadir';

        return [
            $rowNumber,
            $absensi->siswa->nama,
            $absensi->siswa->nisn,
            $absensi->siswa->rombel->nama,
            $statusLabel,
            $absensi->confirmed_at ? \Carbon\Carbon::parse($absensi->confirmed_at)->format('H:i') : '-'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 35,
            'C' => 15,
            'D' => 20,
            'E' => 20,
            'F' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            11 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '4F46E5']]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Judul
                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'PORTAL LES TKA 2026/2027');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                
                $sheet->mergeCells('A2:F2');
                $sheet->setCellValue('A2', 'REKAPITULASI ABSENSI SESI LES');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                // Header Info
                $rombels = $this->sesi->sesi_les_rombels->pluck('rombel.nama')->implode(', ');
                $tanggal = \Carbon\Carbon::parse($this->sesi->waktu_mulai)->translatedFormat('d F Y');
                $waktu = ($this->sesi->waktu_mulai ? $this->sesi->waktu_mulai->format('H:i') : '-') . ' - ' . 
                         ($this->sesi->waktu_selesai ? $this->sesi->waktu_selesai->format('H:i') : '-');

                $sheet->setCellValue('A4', 'Tanggal');
                $sheet->setCellValue('B4', ': ' . $tanggal);
                $sheet->setCellValue('A5', 'Waktu');
                $sheet->setCellValue('B5', ': ' . $waktu);
                $sheet->setCellValue('A6', 'Mata Pelajaran');
                $sheet->setCellValue('B6', ': ' . $this->sesi->mata_pelajaran->nama);
                $sheet->setCellValue('A7', 'Materi');
                $sheet->setCellValue('B7', ': ' . ($this->sesi->materi ?: '-'));
                $sheet->setCellValue('A8', 'Guru');
                $sheet->setCellValue('B8', ': ' . $this->sesi->guru->nama_guru);
                $sheet->setCellValue('A9', 'Rombel');
                $sheet->setCellValue('B9', ': ' . $rombels);
                
                $sheet->getStyle('A4:A9')->getFont()->setBold(true);

                // Borders untuk data tabel
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A11:F' . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Render stats at the bottom
                $r = $highestRow + 2;
                $sheet->setCellValue('A' . $r, 'RINGKASAN ABSENSI');
                $sheet->mergeCells("A$r:C$r");
                $sheet->getStyle('A' . $r)->getFont()->setBold(true)->setSize(12);
                
                $r++;
                $sheet->setCellValue("A$r", "Total Siswa Target");
                $sheet->setCellValue("B$r", ": " . $this->stats['total_expected']);
                $sheet->setCellValue("D$r", "Hadir Valid");
                $sheet->setCellValue("E$r", ": " . $this->stats['hadir_valid']);
                
                $r++;
                $sheet->setCellValue("A$r", "Sakit");
                $sheet->setCellValue("B$r", ": " . $this->stats['sakit']);
                $sheet->setCellValue("D$r", "Izin");
                $sheet->setCellValue("E$r", ": " . $this->stats['izin']);

                $r++;
                $sheet->setCellValue("A$r", "Tidak Hadir");
                $sheet->setCellValue("B$r", ": " . $this->stats['tidak_hadir']);
                $sheet->setCellValue("D$r", "Tidak Konfirmasi");
                $sheet->setCellValue("E$r", ": " . $this->stats['tidak_konfirmasi']);

                $r++;
                $sheet->setCellValue("A$r", "Persentase");
                $sheet->setCellValue("B$r", ": " . $this->stats['persentase'] . '%');

                $sheet->getStyle("A".($highestRow+2).":A$r")->getFont()->setBold(true);
                $sheet->getStyle("D".($highestRow+3).":D$r")->getFont()->setBold(true);
            },
        ];
    }
}
