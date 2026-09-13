<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    public function activityLog()
    {
        // Activity log is ordered by newest first, with pagination
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(50);
        return view('admin.system.activity_log', compact('logs'));
    }

    public function settings()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.system.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        
        DB::transaction(function () use ($data) {
            foreach ($data as $key => $value) {
                if ($value !== null) {
                    Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );
                }
            }
            ActivityLog::log('update', 'system', "Memperbarui pengaturan sistem");
        });

        return redirect()->route('admin.system.settings')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
