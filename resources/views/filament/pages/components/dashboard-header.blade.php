<div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-sm text-white mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Selamat Datang di SIM Perpustakaan 📚</h1>
            <p class="text-sm text-blue-100 mt-1">Halo, {{ auth()->user()->name }}! Kelola sirkulasi buku, anggota, dan denda dengan mudah hari ini.</p>
        </div>
        <div class="hidden md:block text-right">
            <p class="text-xs text-blue-200 uppercase tracking-wider font-semibold">Tanggal Hari Ini</p>
            <p class="text-lg font-medium">{{ now()->translatedFormat('d F Y') }}</p>
        </div>
    </div>
</div>