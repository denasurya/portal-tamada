@extends('layouts.admin')

@section('header', 'User Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">User Management</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola akun Admin dan Kepala Sekolah.</p>
    </div>
    <a href="{{ route('admin.user.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors flex items-center">
        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        Tambah User
    </a>
</div>

<div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6 text-sm text-blue-800 flex items-start">
    <svg class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <div>
        Menu ini hanya untuk mengelola akun dengan role <b>Admin</b> dan <b>Kepsek</b>. Akun Guru dan Siswa otomatis dibuat saat menambahkan data di Master Guru dan Master Siswa.
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3 w-16">No</th>
                    <th class="px-6 py-3">Nama Lengkap</th>
                    <th class="px-6 py-3">Username (Login)</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3 w-32 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $index => $user)
                <tr class="hover:bg-gray-50 {{ auth()->id() === $user->id ? 'bg-indigo-50/30' : '' }}">
                    <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{ $user->nama_lengkap ?: '-' }}
                    </td>
                    <td class="px-6 py-4 font-mono text-gray-600 flex items-center">
                        {{ $user->username }}
                        @if(auth()->id() === $user->id)
                            <span class="ml-2 px-2 py-0.5 bg-indigo-100 text-indigo-700 text-xs rounded-full border border-indigo-200">Anda</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($user->role === 'admin')
                            <span class="px-2 py-1 bg-purple-50 text-purple-700 rounded-md text-xs font-medium border border-purple-100">Admin</span>
                        @elseif($user->role === 'kepsek')
                            <span class="px-2 py-1 bg-yellow-50 text-yellow-700 rounded-md text-xs font-medium border border-yellow-100">Kepala Sekolah</span>
                        @else
                            <span class="px-2 py-1 bg-gray-50 text-gray-700 rounded-md text-xs font-medium border border-gray-100">{{ ucfirst($user->role) }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('admin.user.edit', $user->id) }}" class="inline-flex items-center p-1.5 bg-blue-50 text-blue-600 rounded-md hover:bg-blue-100" title="Edit">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                        
                        @if(auth()->id() !== $user->id)
                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center p-1.5 bg-red-50 text-red-600 rounded-md hover:bg-red-100" title="Hapus">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                        @else
                        <span class="inline-flex items-center p-1.5 text-gray-300 rounded-md cursor-not-allowed" title="Tidak dapat menghapus diri sendiri">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data user admin/kepsek.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
