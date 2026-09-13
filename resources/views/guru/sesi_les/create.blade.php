@extends('layouts.guru')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6 max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Buat Sesi Les Baru</h1>
        <p class="text-sm text-gray-500 mt-1">Isi detail sesi pembelajaran, lalu mulai sesi. Siswa dari rombel yang dipilih akan dapat melihat sesi ini.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">
            <p class="font-semibold text-sm mb-1">Terdapat kesalahan:</p>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('guru.sesi-les.store') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf

        {{-- Mata Pelajaran --}}
        <div>
            <label for="mapel_id" class="block text-sm font-medium text-gray-700 mb-1">
                Mata Pelajaran <span class="text-red-500">*</span>
            </label>
            <select
                id="mapel_id"
                name="mapel_id"
                onchange="fetchRombels(this.value)"
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border text-sm"
                required
            >
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach($mapels as $gm)
                    <option value="{{ $gm->mata_pelajaran->id }}">{{ $gm->mata_pelajaran->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- Rombel Target (Dynamic - pure JS, no AlpineJS) --}}
        <div id="rombel-loading" style="display:none;" class="text-sm text-indigo-600 animate-pulse">
            Memuat daftar rombel...
        </div>

        <div id="rombel-container" style="display:none;">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Pilih Rombel Target <span class="text-red-500">*</span>
            </label>
            <p class="text-xs text-gray-500 mb-3">Siswa dari rombel yang dipilih akan dapat melihat sesi ini.</p>
            <div id="rombel-list" class="grid grid-cols-2 md:grid-cols-3 gap-3">
                {{-- Diisi via JS --}}
            </div>
        </div>

        <div id="rombel-empty" style="display:none;">
            <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-700">
                Tidak ada rombel penugasan untuk mata pelajaran ini. Hubungi Admin.
            </div>
        </div>

        {{-- Materi --}}
        <div>
            <label for="materi" class="block text-sm font-medium text-gray-700 mb-1">
                Materi Pembelajaran <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="materi"
                name="materi"
                required
                placeholder="Contoh: Persamaan Kuadrat Bab 3"
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border text-sm"
            >
        </div>

        {{-- File Materi --}}
        <div>
            <label for="file_materi" class="block text-sm font-medium text-gray-700 mb-1">
                Upload File Materi (Opsional)
            </label>
            <p class="text-xs text-gray-500 mb-2">Bisa diupload sekarang atau nanti. Format: PDF, Word, PPT, ZIP, RAR (Maks 10MB).</p>
            <input
                type="file"
                id="file_materi"
                name="file_materi"
                accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.rar,.txt"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-lg shadow-sm"
            >
        </div>

        {{-- Google Meet Link --}}
        <div>
            <label for="gmeet_link" class="block text-sm font-medium text-gray-700 mb-1">
                Link Google Meet
            </label>
            <p class="text-xs text-gray-500 mb-2">Siswa dapat langsung join setelah sesi dimulai, sebelum proses absensi.</p>
            <input
                type="url"
                id="gmeet_link"
                name="gmeet_link"
                placeholder="https://meet.google.com/xxx-xxxx-xxx"
                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border text-sm"
            >
        </div>

        {{-- Submit --}}
        <div class="pt-2">
            <button
                type="submit"
                class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Mulai Sesi Les
            </button>
        </div>
    </form>
</div>

<script>
(function() {
    var ROMBEL_URL = '{{ route('guru.sesi-les.get-rombel') }}';

    function fetchRombels(mapelId) {
        var loading   = document.getElementById('rombel-loading');
        var container = document.getElementById('rombel-container');
        var listEl    = document.getElementById('rombel-list');
        var emptyEl   = document.getElementById('rombel-empty');

        // Reset semua
        loading.style.display   = 'none';
        container.style.display = 'none';
        emptyEl.style.display   = 'none';
        listEl.innerHTML        = '';

        if (!mapelId) return;

        loading.style.display = 'block';

        fetch(ROMBEL_URL + '?mapel_id=' + encodeURIComponent(mapelId))
            .then(function(res) { return res.json(); })
            .then(function(data) {
                loading.style.display = 'none';

                if (!data || data.length === 0) {
                    emptyEl.style.display = 'block';
                    return;
                }

                data.forEach(function(rombel) {
                    var label = document.createElement('label');
                    label.className = 'inline-flex items-center p-3 border rounded-lg cursor-pointer hover:bg-indigo-50 hover:border-indigo-300 transition';

                    var checkbox = document.createElement('input');
                    checkbox.type      = 'checkbox';
                    checkbox.name      = 'rombels[]';
                    checkbox.value     = rombel.rombel_id;
                    checkbox.className = 'rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500';

                    var span = document.createElement('span');
                    span.className   = 'ml-2 text-sm font-medium';
                    span.textContent = (rombel.rombel && rombel.rombel.nama) ? rombel.rombel.nama : '-';

                    label.appendChild(checkbox);
                    label.appendChild(span);
                    listEl.appendChild(label);
                });

                container.style.display = 'block';
            })
            .catch(function() {
                loading.style.display = 'none';
                emptyEl.style.display = 'block';
            });
    }

    // Expose globally agar onchange attribute bisa memanggilnya
    window.fetchRombels = fetchRombels;
})();
</script>
@endsection

