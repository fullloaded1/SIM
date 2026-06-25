<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 p-2">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-amber-500/10 text-amber-500 rounded-full dark:bg-amber-500/20">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white">
                        Selamat Datang Kembali, {{ auth()->user()->name }}! 👋
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 italic font-serif">
                        "Buku-buku di sini adalah ketidaksengajaan yang menanti untuk ditemukan, menyimpan ribuan tahun penantian ilmu pengetahuan yang siap menuntun para pencari cahaya."
                    </p>
                </div>
            </div>
            <div class="text-right hidden md:block">
                <div class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->translatedFormat('l, d F Y') }}
                </div>
                <div class="text-xs text-amber-500 font-semibold mt-0.5">
                    Kelompok 10 - Pemrograman Web
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>