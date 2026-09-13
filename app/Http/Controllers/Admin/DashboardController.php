<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\SesiLes;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_guru' => Guru::count(),
            'total_siswa' => Siswa::count(),
            'total_rombel' => Rombel::count(),
            'total_mapel' => MataPelajaran::count(),
            'total_sesi' => SesiLes::count(),
            'sesi_aktif' => SesiLes::where('status', 'berjalan')->count(),
            'total_users' => User::count(),
        ];

        // 5 Sesi terakhir
        $recent_sessions = SesiLes::with('guru', 'mata_pelajaran', 'sesi_les_rombels.rombel')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_sessions'));
    }
}
