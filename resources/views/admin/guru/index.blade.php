@extends('layouts.admin')

@section('header', 'Master Guru')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Master Guru</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola data guru dan akun penggunanya.</p>
    </div>
    <a href="{{ route('admin.guru.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors flex items-center">
        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Guru
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3 w-16">No</th>
                    <th class="px-6 py-3 w-32">Kode Guru</th>
                    <th class="px-6 py-3">Nama Guru</th>
                    <th class="px-6 py-3">Username</th>
                    <th class="px-6 py-3">Mapel Diampu</th>
                    <th class="px-6 py-3 w-40 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($gurus as $index => $guru)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-medium text-gray-600">{{ $guru->kode_guru }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $guru->nama_guru }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $guru->user->username ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $guru->guru_mapels->count() }} Mapel
                    </td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('admin.guru.show', $guru->id) }}" class="inline-flex items-center p-1.5 bg-green-50 text-green-600 rounded-md hover:bg-green-100" title="Atur Penugasan">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </a>
                        <a href="{{ route('admin.guru.edit', $guru->id) }}" class="inline-flex items-center p-1.5 bg-blue-50 text-blue-600 rounded-md hover:bg-blue-100" title="Edit">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                        <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus guru ini beserta akun penggunanya?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center p-1.5 bg-red-50 text-red-600 rounded-md hover:bg-red-100" title="Hapus">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data guru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
