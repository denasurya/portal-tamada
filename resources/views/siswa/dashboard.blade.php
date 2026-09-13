@extends('layouts.app')

@section('content')
    <div class="space-y-6">

        {{-- Header Profil --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Dashboard Siswa</h1>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-indigo-50 rounded-lg p-4">
                    <p class="text-xs text-indigo-400 font-medium uppercase tracking-wide">Nama</p>
                    <p class="text-sm font-bold text-indigo-700 mt-1">{{ $siswa->nama ?? 'N/A' }}</p>
                </div>
                <div class="bg-indigo-50 rounded-lg p-4">
                    <p class="text-xs text-indigo-400 font-medium uppercase tracking-wide">NISN</p>
                    <p class="text-sm font-bold text-indigo-700 mt-1">{{ $siswa->nisn ?? 'N/A' }}</p>
                </div>
                <div class="bg-indigo-50 rounded-lg p-4">
                    <p class="text-xs text-indigo-400 font-medium uppercase tracking-wide">Rombel</p>
                    <p class="text-sm font-bold text-indigo-700 mt-1">{{ $siswa->rombel->nama ?? 'N/A' }}</p>
                </div>
                <div class="bg-indigo-50 rounded-lg p-4">
                    <p class="text-xs text-indigo-400 font-medium uppercase tracking-wide">Jurusan</p>
                    <p class="text-sm font-bold text-indigo-700 mt-1">{{ $siswa->rombel->jurusan->nama ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 flex items-center gap-2">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- SESI AKTIF --}}
        <div>
            <h2 class="text-lg font-bold text-gray-700 mb-4 flex items-center gap-2">
                <span class="relative flex h-3 w-3">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                Sesi Les Aktif untuk Rombel Anda
            </h2>

            @forelse($sesi_aktif as $sesi)
                @php
                    $absensi = $sesi->absensi_siswas->first();
                    $statusSiswa = $absensi ? $absensi->status : 'belum_diabsen';
                @endphp

                <div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-4" id="sesi-card-{{ $sesi->id }}"
                    x-data="konfirmasiManager({{ $sesi->id }}, '{{ $statusSiswa }}')">

                    {{-- Info Sesi --}}
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Sedang Berlangsung
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">{{ $sesi->mata_pelajaran->nama }}</h3>
                                <div class="mt-2 space-y-1">
                                    <p class="text-sm text-gray-600">
                                        <span class="text-gray-400">Guru:</span>
                                        <span class="font-medium">{{ $sesi->guru->nama_guru }}</span>
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <span class="text-gray-400">Materi:</span>
                                        <span class="font-medium">{{ $sesi->materi }}</span>
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <span class="text-gray-400">Rombel:</span>
                                        <span
                                            class="font-medium">{{ $sesi->sesi_les_rombels->pluck('rombel.nama')->implode(', ') }}</span>
                                    </p>
                                    <p class="text-sm text-gray-400">Dimulai: {{ $sesi->waktu_mulai->format('H:i') }}</p>
                                    @if($sesi->file_materi)
                                    <div class="mt-3">
                                        <a href="{{ asset('storage/' . $sesi->file_materi) }}" target="_blank"
                                            class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-700 px-3 py-2 rounded-lg border border-indigo-200 text-xs font-semibold hover:bg-indigo-100 transition shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Download Materi
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Tombol JOIN GOOGLE MEET (tersedia langsung, tanpa syarat) --}}
                            @if($sesi->gmeet_link)
                                <div class="flex-shrink-0">
                                    <a href="{{ $sesi->gmeet_link }}" target="_blank"
                                        class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-3 rounded-xl font-semibold text-sm hover:bg-blue-700 transition shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        Join Google Meet
                                    </a>
                                    <p class="text-xs text-gray-400 text-center mt-1">KLIK JOIN UNTUK BERGABUNG</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Status Absensi Siswa --}}
                    <div class="p-6">
                        <h4 class="text-sm font-semibold text-gray-600 mb-4">Status Kehadiran Anda</h4>

                        {{-- Status: Belum Diabsen --}}
                        <div x-show="currentStatus === 'belum_diabsen'" x-cloak
                            class="p-4 bg-gray-50 rounded-xl border border-gray-200 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">Menunggu guru memanggil Anda</p>
                            <p class="text-xs text-gray-400 mt-1">Guru akan mencatat kehadiran Anda saat dipanggil di Google
                                Meet</p>
                        </div>

                        {{-- Status: Menunggu Konfirmasi --}}
                        <div x-show="currentStatus === 'menunggu_konfirmasi'" x-cloak class="space-y-4">
                            <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 mt-0.5">
                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-yellow-800">Guru telah mencatat Anda hadir</p>
                                        <p class="text-xs text-yellow-600 mt-1">Konfirmasi kehadiran Anda sekarang untuk
                                            mendapatkan status Hadir Valid.</p>

                                        <div class="mt-3 text-xs text-yellow-700 space-y-1">
                                            <p>📚 Mata Pelajaran: <strong>{{ $sesi->mata_pelajaran->nama }}</strong></p>
                                            <p>👨‍🏫 Guru: <strong>{{ $sesi->guru->nama_guru }}</strong></p>
                                            <p>📝 Materi: <strong>{{ $sesi->materi }}</strong></p>
                                            <p>📅 Waktu: <strong>{{ $sesi->waktu_mulai->format('d/m/Y H:i') }}</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" @click="doKonfirmasi()" :disabled="isLoading"
                                class="w-full py-4 px-6 bg-green-600 text-white rounded-xl font-bold text-base hover:bg-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <span x-show="!isLoading">✓ KONFIRMASI KEHADIRAN</span>
                                <span x-show="isLoading" class="flex items-center gap-2">
                                    <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    Memproses...
                                </span>
                            </button>

                            <div x-show="errorMsg" x-cloak
                                class="p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600" x-text="errorMsg">
                            </div>
                        </div>

                        {{-- Status: Hadir Valid --}}
                        <div x-show="currentStatus === 'hadir_valid'" x-cloak
                            class="p-6 bg-green-50 rounded-xl border border-green-200 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-xl font-bold text-green-700">✓ HADIR VALID</p>
                            <p class="text-sm text-green-600 mt-1">Kehadiran Anda telah terkonfirmasi dan tercatat.</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm p-10 text-center border-2 border-dashed border-gray-200">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-500 font-medium">Tidak ada sesi les aktif saat ini</p>
                    <p class="text-gray-400 text-sm mt-1">Sesi akan muncul di sini saat guru memulai pembelajaran untuk rombel
                        Anda.</p>
                </div>
            @endforelse
        </div>

        {{-- Histori Kehadiran --}}
        @if($histori->count() > 0)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-700 mb-4">Histori Kehadiran</h2>
                <div class="space-y-3">
                    @foreach($histori as $h)
                        @php
                            $absensiH = $h->absensi_siswas->first();
                            $statusH = $absensiH ? $absensiH->status : 'tidak_hadir';
                        @endphp
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $h->mata_pelajaran->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $h->guru->nama_guru }} •
                                    {{ $h->waktu_mulai->format('d/m/Y H:i') }}</p>
                                <p class="text-xs text-gray-400">Materi: {{ $h->materi }}</p>
                                @if($h->file_materi)
                                <div class="mt-1">
                                    <a href="{{ asset('storage/' . $h->file_materi) }}" target="_blank" class="text-xs text-indigo-600 hover:underline flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        Download Materi
                                    </a>
                                </div>
                                @endif
                            </div>
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $statusH === 'hadir_valid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $statusH === 'hadir_valid' ? 'Hadir Valid' : 'Tidak Hadir' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    <script>
        function konfirmasiManager(sesiId, initialStatus) {
            return {
                currentStatus: initialStatus,
                isLoading: false,
                errorMsg: '',

                doKonfirmasi() {
                    this.isLoading = true;
                    this.errorMsg = '';

                    fetch(`/siswa/konfirmasi/${sesiId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.isLoading = false;
                            if (data.success) {
                                this.currentStatus = 'hadir_valid';
                            } else {
                                this.errorMsg = data.message || 'Terjadi kesalahan.';
                            }
                        })
                        .catch(() => {
                            this.isLoading = false;
                            this.errorMsg = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                        });
                },

                // Polling status untuk update real-time
                startPolling() {
                    const self = this;
                    function poll() {
                        if (self.currentStatus === 'hadir_valid') return; // sudah valid, stop polling

                        fetch(`/siswa/status/${sesiId}`, {
                            headers: { 'Accept': 'application/json' }
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    if (data.status !== self.currentStatus) {
                                        self.currentStatus = data.status;
                                    }
                                    if (data.sesi_status !== 'selesai' && data.status !== 'hadir_valid') {
                                        setTimeout(poll, 10000); // polling tiap 10 detik
                                    }
                                }
                            })
                            .catch(() => {
                                setTimeout(poll, 15000);
                            });
                    }

                    // Mulai polling jika belum hadir valid
                    if (this.currentStatus !== 'hadir_valid') {
                        setTimeout(poll, 10000);
                    }
                },

                init() {
                    this.startPolling();
                }
            }
        }
    </script>
@endsection