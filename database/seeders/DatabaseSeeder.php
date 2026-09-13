<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Jurusan;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\GuruMapel;
use App\Models\PenugasanRombel;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create default Admin
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );

        User::firstOrCreate(
            ['username' => 'kepsek'],
            [
                'password' => Hash::make('kepsek123'),
                'role' => 'kepsek'
            ]
        );

        // 2. Parse Siswa CSV
        $siswaFile = fopen(base_path('DATA SISWA KELAS XII.csv'), 'r');
        fgetcsv($siswaFile); // skip header (no,nama,jk,nisn,rombel)
        
        $siswaPassword = Hash::make('siswa123'); // Cache password hash for speed
        while (($row = fgetcsv($siswaFile)) !== false) {
            if (count($row) < 5) continue;
            
            $nama = trim($row[1]);
            $jk = trim($row[2]);
            $nisn = trim($row[3]);
            $rombel_nama = trim($row[4]);
            
            if (empty($nisn) || empty($rombel_nama)) continue;

            // Determine Jurusan from Rombel (e.g., XII TKR 1 -> TKR)
            $parts = explode(' ', $rombel_nama);
            $jurusan_kode = $parts[1] ?? 'UNKNOWN';

            $jurusan = Jurusan::firstOrCreate(
                ['kode' => $jurusan_kode],
                ['nama' => $jurusan_kode]
            );

            $rombel = Rombel::firstOrCreate(
                ['nama' => $rombel_nama],
                ['jurusan_id' => $jurusan->id]
            );

            // Create user for siswa
            $user = User::firstOrCreate(
                ['username' => $nisn],
                [
                    'password' => $siswaPassword, // Default password
                    'role' => 'siswa'
                ]
            );

            Siswa::firstOrCreate(
                ['nisn' => $nisn],
                [
                    'user_id' => $user->id,
                    'rombel_id' => $rombel->id,
                    'nama' => $nama,
                    'jk' => $jk
                ]
            );
        }
        fclose($siswaFile);

        // 3. Parse Official Guru CSV
        $guruFilePath = base_path('data guru resmi.csv');
        if (file_exists($guruFilePath)) {
            $guruFile = fopen($guruFilePath, 'r');
            fgetcsv($guruFile); // skip header (nama,mapel,rombel_1..rombel_11)

            $mapelMap = [
                'B INDO' => ['kode' => 'BIN', 'nama' => 'Bahasa Indonesia'],
                'MTK' => ['kode' => 'MAT', 'nama' => 'Matematika'],
                'B ING' => ['kode' => 'BIG', 'nama' => 'Bahasa Inggris'],
                'SEJARAH' => ['kode' => 'SEJ', 'nama' => 'Sejarah'],
                'PP' => ['kode' => 'PPKN', 'nama' => 'Pendidikan Pancasila']
            ];

            $guruPassword = Hash::make('guru123');
            $counter = 1;

            while (($row = fgetcsv($guruFile)) !== false) {
                if (count($row) < 2) continue;

                $nama = trim($row[0]);
                $mapel_csv = trim($row[1]);
                if (empty($nama)) continue;

                $username = 'guru.' . strtolower(str_replace(' ', '', $nama));
                $user = User::firstOrCreate(
                    ['username' => $username],
                    [
                        'password' => $guruPassword,
                        'role' => 'guru'
                    ]
                );

                $kode_guru = 'G' . str_pad($counter++, 3, '0', STR_PAD_LEFT);
                $guru = Guru::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'kode_guru' => $kode_guru,
                        'nama_guru' => $nama,
                        'status_data' => 'AKTIF'
                    ]
                );

                $mapelInfo = $mapelMap[$mapel_csv] ?? ['kode' => $mapel_csv, 'nama' => $mapel_csv];
                $mapel = MataPelajaran::firstOrCreate(
                    ['nama' => $mapelInfo['nama']],
                    ['kode' => $mapelInfo['kode']]
                );

                $guruMapel = GuruMapel::firstOrCreate([
                    'guru_id' => $guru->id,
                    'mata_pelajaran_id' => $mapel->id
                ]);

                for ($i = 2; $i < count($row); $i++) {
                    $rombel_nama = trim($row[$i]);
                    if (!empty($rombel_nama)) {
                        $rombel = Rombel::where('nama', $rombel_nama)->first();
                        if ($rombel) {
                            PenugasanRombel::firstOrCreate([
                                'guru_mapel_id' => $guruMapel->id,
                                'rombel_id' => $rombel->id
                            ]);
                        }
                    }
                }
            }
            fclose($guruFile);
        }
    }
}
