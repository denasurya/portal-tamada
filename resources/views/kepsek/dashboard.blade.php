@extends('layouts.kepsek')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Command Center</h1>
                <p class="text-sm text-gray-500 mt-1">Monitoring kehadiran sesi les TKA secara real-time</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="text-xs text-gray-500" id="last-update">Live Monitoring</span>
            </div>
        </div>
    </div>

    {{-- Sesi Aktif Grid --}}
    <div id="sesi-container">
        @if(count($sesi_aktif) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($sesi_aktif as $sesi)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" id="sesi-kepsek-{{ $sesi['id'] }}">
                {{-- Header Sesi --}}
                <div class="p-5 border-b border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                                </span>
                                <span class="text-xs text-green-600 font-medium">Sedang Berlangsung</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $sesi['mata_pelajaran'] }}</h3>
                            <p class="text-sm text-gray-500">Guru: <span class="font-medium text-gray-700">{{ $sesi['guru'] }}</span></p>
                            <p class="text-sm text-gray-500">Materi: <span class="font-medium text-gray-700">{{ $sesi['materi'] }}</span></p>
                            <p class="text-xs text-gray-400 mt-1">Mulai: {{ $sesi['waktu_mulai_full'] }}</p>
                            
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Rombel: <span class="font-normal">{{ $sesi['rombels'] }}</span></p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                        Total Siswa: <span id="header-total-{{ $sesi['id'] }}">{{ $sesi['total_expected'] }}</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                        Sudah Diabsen: <span id="header-sudah-{{ $sesi['id'] }}">{{ $sesi['sudah_diabsen'] }}</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-100">
                                        Menunggu Konfirmasi: <span id="header-menunggu-{{ $sesi['id'] }}">{{ $sesi['menunggu_konfirmasi'] }}</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                        Hadir Valid: <span id="header-hadir-{{ $sesi['id'] }}">{{ $sesi['hadir_valid'] }}</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                                        Tidak Hadir: <span id="header-tidak-{{ $sesi['id'] }}">{{ $sesi['tidak_hadir'] }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            @if($sesi['gmeet_link'])
                            <a href="{{ $sesi['gmeet_link'] }}" target="_blank"
                                class="inline-flex items-center gap-1 text-xs text-blue-600 hover:text-blue-800 bg-blue-50 px-2 py-1 rounded-lg">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                Google Meet
                            </a>
                            @endif
                            @if($sesi['bukti_path'])
                            <a href="{{ asset('storage/' . $sesi['bukti_path']) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-green-600 hover:text-green-800 bg-green-50 px-2 py-1 rounded-lg mt-1 justify-end float-right clear-both transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Bukti Terupload
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Statistik Total Sesi --}}
                <div class="p-5 bg-gradient-to-br from-gray-50 to-white border-b border-gray-100">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Kehadiran Keseluruhan</span>
                        <span class="text-2xl font-bold" id="persen-total-{{ $sesi['id'] }}"
                              style="color: {{ $sesi['persentase'] >= 80 ? '#16a34a' : ($sesi['persentase'] >= 50 ? '#d97706' : '#dc2626') }}">
                            {{ $sesi['persentase'] }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-3 overflow-hidden">
                        <div class="h-2.5 rounded-full transition-all duration-700"
                             id="progress-kepsek-{{ $sesi['id'] }}"
                             style="width: {{ $sesi['persentase'] }}%; background: {{ $sesi['persentase'] >= 80 ? '#16a34a' : ($sesi['persentase'] >= 50 ? '#d97706' : '#dc2626') }}">
                        </div>
                    </div>
                    <div class="grid grid-cols-4 gap-2 text-center">
                        <div>
                            <p class="text-lg font-bold text-gray-700" id="stat-kepsek-total-{{ $sesi['id'] }}">{{ $sesi['total_expected'] }}</p>
                            <p class="text-xs text-gray-400">Total</p>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-green-600" id="stat-kepsek-hadir-{{ $sesi['id'] }}">{{ $sesi['hadir_valid'] }}</p>
                            <p class="text-xs text-green-500">Hadir Valid</p>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-yellow-600" id="stat-kepsek-menunggu-{{ $sesi['id'] }}">{{ $sesi['menunggu_konfirmasi'] }}</p>
                            <p class="text-xs text-yellow-500">Menunggu</p>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-gray-400" id="stat-kepsek-belum-{{ $sesi['id'] }}">{{ $sesi['belum_diabsen'] }}</p>
                            <p class="text-xs text-gray-400">Belum</p>
                        </div>
                    </div>
                </div>

                {{-- Detail Per Rombel --}}
                <div class="p-5">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Detail Per Rombel</h4>
                    <div class="space-y-3" id="rombel-detail-{{ $sesi['id'] }}">
                        @foreach($sesi['rombel_stats'] as $rs)
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-semibold text-gray-700">{{ $rs['rombel_nama'] }}</span>
                                <span class="text-sm font-bold {{ $rs['persentase'] >= 80 ? 'text-green-600' : ($rs['persentase'] >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $rs['persentase'] }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 mb-2">
                                <div class="h-1.5 rounded-full {{ $rs['persentase'] >= 80 ? 'bg-green-500' : ($rs['persentase'] >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                     style="width: {{ $rs['persentase'] }}%"></div>
                            </div>
                            <div class="grid grid-cols-4 gap-1 text-center text-xs">
                                <div>
                                    <span class="font-semibold text-gray-600">{{ $rs['total_siswa'] }}</span>
                                    <p class="text-gray-400">Total</p>
                                </div>
                                <div>
                                    <span class="font-semibold text-green-600">{{ $rs['hadir_valid'] }}</span>
                                    <p class="text-green-400">Valid</p>
                                </div>
                                <div>
                                    <span class="font-semibold text-yellow-600">{{ $rs['menunggu_konfirmasi'] }}</span>
                                    <p class="text-yellow-400">Menunggu</p>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-400">{{ $rs['belum_diabsen'] }}</span>
                                    <p class="text-gray-300">Belum</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-xl shadow-sm p-12 text-center border-2 border-dashed border-gray-200">
            <svg class="mx-auto h-16 w-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-xl font-semibold text-gray-400">Tidak ada sesi les yang sedang berjalan</p>
            <p class="text-sm text-gray-400 mt-2">Data akan muncul secara otomatis saat guru memulai sesi.</p>
        </div>
        @endif
    </div>

</div>

<script>
/**
 * Polling real-time untuk Kepsek Command Center
 * Mengupdate statistik setiap 15 detik
 */
function pollKepsek() {
    fetch('/kepsek/stats', {
        headers: { 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) return;

        const now = new Date().toLocaleTimeString('id-ID');
        const lastUpdateEl = document.getElementById('last-update');
        if (lastUpdateEl) lastUpdateEl.textContent = 'Diperbarui: ' + now;

        // Update setiap sesi
        data.sesi_aktif.forEach(sesi => {
            // Update stat angka
            const updateEl = (id, val) => {
                const el = document.getElementById(id);
                if (el && el.textContent !== String(val)) el.textContent = val;
            };

            updateEl(`stat-kepsek-total-${sesi.id}`, sesi.total_expected);
            updateEl(`stat-kepsek-hadir-${sesi.id}`, sesi.hadir_valid);
            updateEl(`stat-kepsek-menunggu-${sesi.id}`, sesi.menunggu_konfirmasi);
            updateEl(`stat-kepsek-belum-${sesi.id}`, sesi.belum_diabsen);

            // Update header detail text
            updateEl(`header-total-${sesi.id}`, sesi.total_expected);
            updateEl(`header-sudah-${sesi.id}`, sesi.sudah_diabsen);
            updateEl(`header-menunggu-${sesi.id}`, sesi.menunggu_konfirmasi);
            updateEl(`header-hadir-${sesi.id}`, sesi.hadir_valid);
            updateEl(`header-tidak-${sesi.id}`, sesi.tidak_hadir);

            // Update persentase
            const persenEl = document.getElementById(`persen-total-${sesi.id}`);
            if (persenEl) {
                persenEl.textContent = sesi.persentase + '%';
                const color = sesi.persentase >= 80 ? '#16a34a' : (sesi.persentase >= 50 ? '#d97706' : '#dc2626');
                persenEl.style.color = color;
            }

            // Update progress bar
            const progressEl = document.getElementById(`progress-kepsek-${sesi.id}`);
            if (progressEl) {
                progressEl.style.width = sesi.persentase + '%';
                const color = sesi.persentase >= 80 ? '#16a34a' : (sesi.persentase >= 50 ? '#d97706' : '#dc2626');
                progressEl.style.background = color;
            }

            // Update detail per rombel HTML
            const rombelContainer = document.getElementById(`rombel-detail-${sesi.id}`);
            if (rombelContainer && sesi.rombel_stats) {
                let html = '';
                sesi.rombel_stats.forEach(rs => {
                    const colorClass = rs.persentase >= 80 ? 'text-green-600' : (rs.persentase >= 50 ? 'text-yellow-600' : 'text-red-600');
                    const bgClass = rs.persentase >= 80 ? 'bg-green-500' : (rs.persentase >= 50 ? 'bg-yellow-500' : 'bg-red-500');
                    html += `
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-semibold text-gray-700">${rs.rombel_nama}</span>
                                <span class="text-sm font-bold ${colorClass}">${rs.persentase}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 mb-2">
                                <div class="h-1.5 rounded-full ${bgClass}" style="width: ${rs.persentase}%"></div>
                            </div>
                            <div class="grid grid-cols-4 gap-1 text-center text-xs">
                                <div><span class="font-semibold text-gray-600">${rs.total_siswa}</span><p class="text-gray-400">Total</p></div>
                                <div><span class="font-semibold text-green-600">${rs.hadir_valid}</span><p class="text-green-400">Valid</p></div>
                                <div><span class="font-semibold text-yellow-600">${rs.menunggu_konfirmasi}</span><p class="text-yellow-400">Menunggu</p></div>
                                <div><span class="font-semibold text-gray-400">${rs.belum_diabsen}</span><p class="text-gray-300">Belum</p></div>
                            </div>
                        </div>
                    `;
                });
                rombelContainer.innerHTML = html;
            }
        });
        setTimeout(pollKepsek, 15000); // polling tiap 15 detik
    })
    .catch(() => {
        setTimeout(pollKepsek, 20000); // retry lebih lambat jika error
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Mulai polling setelah 15 detik pertama
    setTimeout(pollKepsek, 15000);
});
</script>
@endsection
