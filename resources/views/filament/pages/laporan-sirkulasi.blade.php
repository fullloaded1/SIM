<x-filament-panels::page>
    <!-- CSS Khusus untuk Menyembunyikan Sidebar & Header Saat Cetak/Print -->
    <style>
        @media print {
            body { background: white; color: black; }
            .no-print, header, sidebar, nav, .fi-sidebar, .fi-topbar, .fi-actions, form { display: none !important; }
            .print-layout { width: 100% !important; max-width: 100% !important; padding: 0 !important; margin: 0 !important; }
            .print-card { border: none !important; box-shadow: none !important; background: transparent !important; }
        }
    </style>

    <div class="print-layout space-y-6">
        
        <!-- 1. FORM FILTER TANGGAL (no-print: hilang saat dicetak) -->
        <div class="no-print bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai</label>
                    <input type="date" wire:model.live="tgl_mulai" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-transparent text-sm p-2.5 focus:border-amber-500 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Selesai</label>
                    <input type="date" wire:model.live="tgl_selesai" class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-transparent text-sm p-2.5 focus:border-amber-500 focus:ring-amber-500">
                </div>
                <!-- BUTTON ACTION CETAK -->
                <div>
                    <button onclick="window.print()" class="w-full flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-bold py-2.5 px-4 rounded-lg shadow transition text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.8A8.001 8.001 0 1 1 20 12v1a2 2 0 0 1-2 2h-1.5a1.5 1.5 0 0 0-1.5 1.5V18a2 2 0 0 1-2 2h-4.5A2.25 2.25 0 0 1 6 17.75V15c0-.69.114-1.35.325-1.97M6.72 13.8A8.25 8.25 0 0 1 6 12H3m14.72-2.25A8.25 8.25 0 0 0 12 3M12 3v3.75m0 10.5V21M12 11.25H21"></path>
                        </svg>
                        Cetak Laporan (PDF)
                    </button>
                </div>
            </div>
        </div>

        <!-- 2. KOP SURAT LAPORAN (Hanya muncul saat dicetak/print) -->
        <div class="hidden print:block text-center space-y-2 border-b-2 border-slate-900 pb-4">
            <h1 class="text-2xl font-black uppercase tracking-wide text-black">AHSIM PERPUSTAKAAN DIGITAL</h1>
            <p class="text-xs text-gray-600 font-medium">Sekolah Tinggi Teknologi Terpadu Nurul Fikri • Kelompok 10 Pemrograman Web</p>
            <p class="text-sm font-bold text-slate-800 mt-2">LAPORAN DATA SIRKULASI PEMINJAMAN BUKU</p>
            <p class="text-xs text-gray-500">Periode: {{ \Carbon\Carbon::parse($tgl_mulai)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($tgl_selesai)->format('d M Y') }}</p>
        </div>

        <!-- 3. MINI STATS OVERVIEW LAPORAN -->
        <div class="grid grid-cols-3 gap-4">
            <div class="print-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 text-center">
                <div class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Transaksi</div>
                <div class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $this->stats['total'] }}</div>
            </div>
            <div class="print-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 text-center">
                <div class="text-xs text-amber-500 font-bold uppercase tracking-wider">Masih Dipinjam</div>
                <div class="text-2xl font-extrabold text-amber-500 mt-1">{{ $this->stats['dipinjam'] }}</div>
            </div>
            <div class="print-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 text-center">
                <div class="text-xs text-emerald-500 font-bold uppercase tracking-wider">Sudah Kembali</div>
                <div class="text-2xl font-extrabold text-emerald-500 mt-1">{{ $this->stats['kembali'] }}</div>
            </div>
        </div>

        <!-- 4. TABEL UTAMA LAPORAN -->
        <div class="print-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 text-xs font-bold uppercase text-gray-400 tracking-wider">
                        <th class="p-4 text-center w-12">No</th>
                        <th class="p-4">Nama Anggota</th>
                        <th class="p-4">Judul Buku</th>
                        <th class="p-4 text-center">Tgl Pinjam</th>
                        <th class="p-4 text-center">Jatuh Tempo</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300">
                    @forelse($this->report_data as $index => $row)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition">
                            <td class="p-4 text-center text-gray-400">{{ $index + 1 }}</td>
                            <td class="p-4 font-bold text-gray-900 dark:text-white">{{ $row->anggota->nama ?? '-' }}</td>
                            <td class="p-4 text-gray-500 dark:text-gray-400">{{ $row->buku->judul ?? '-' }}</td>
                            <td class="p-4 text-center">{{ \Carbon\Carbon::parse($row->tgl_pinjam)->format('d M Y') }}</td>
                            <td class="p-4 text-center text-amber-500">{{ \Carbon\Carbon::parse($row->tgl_jatuh_tempo)->format('d M Y') }}</td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-md {{ $row->status === 'dipinjam' ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }}">
                                    {{ ucfirst($row->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400 font-medium">Tidak ada data transaksi sirkulasi pada rentang tanggal ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-filament-panels::page>