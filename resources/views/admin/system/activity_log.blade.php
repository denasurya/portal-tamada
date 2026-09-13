@extends('layouts.admin')

@section('header', 'Aktivitas Sistem')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Log Aktivitas Sistem</h1>
    <p class="text-sm text-gray-500 mt-1">Pantau semua perubahan dan aktivitas pengguna dalam sistem.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3 w-48">Waktu</th>
                    <th class="px-6 py-3 w-40">User (Role)</th>
                    <th class="px-6 py-3 w-32">Modul</th>
                    <th class="px-6 py-3 w-32">Aksi</th>
                    <th class="px-6 py-3">Deskripsi / Detail</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-500 text-xs">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{ $log->user->username ?? 'Sistem / Guest' }}
                        <span class="block text-xs font-normal text-gray-500">{{ $log->user ? ucfirst($log->user->role) : '-' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-medium uppercase tracking-wide">
                            {{ $log->module }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $actionColors = [
                                'create' => 'bg-green-50 text-green-700 border-green-200',
                                'update' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'delete' => 'bg-red-50 text-red-700 border-red-200',
                                'login' => 'bg-purple-50 text-purple-700 border-purple-200',
                                'logout' => 'bg-gray-50 text-gray-700 border-gray-200',
                                'assign' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                'import' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                            ];
                            $colorClass = $actionColors[$log->action] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                        @endphp
                        <span class="px-2 py-1 rounded text-xs font-semibold border {{ $colorClass }} uppercase">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $log->description }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada catatan log aktivitas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection
