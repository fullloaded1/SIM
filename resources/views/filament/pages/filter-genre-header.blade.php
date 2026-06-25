<div class="flex flex-col gap-4 w-full">
    
    <div class="flex items-center justify-between w-full px-1">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">Bukus</h1>
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Bukus &gt; List</div>
        </div>
        
        <div class="flex items-center gap-3">
            <x-filament-actions::actions :actions="$actions" class="shrink-0" />
        </div>
    </div>

    <div x-data="{ 
            selectedGenre: new URLSearchParams(window.location.search).get('kategori') || 'semua',
            filterByGenre(namaKategori) {
                this.selectedGenre = namaKategori;
                let url = new URL(window.location.href);
                
                if (namaKategori === 'semua') {
                    url.searchParams.delete('kategori');
                } else {
                    url.searchParams.set('kategori', namaKategori);
                }
                window.location.href = url.toString();
            }
         }" 
         class="flex flex-wrap items-center gap-2 p-2.5 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm w-full mt-1">
        
        <button @click="filterByGenre('semua')" 
                :class="selectedGenre === 'semua' 
                    ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-500/20 ring-1 ring-blue-500 dark:bg-blue-500' 
                    : 'bg-gray-50 dark:bg-gray-800/40 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 border border-gray-200 dark:border-gray-700'"
                class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold rounded-lg cursor-pointer transition-all duration-200 ease-in-out border-none outline-none select-none">
            📚 Semua Genre
        </button>
        
        @foreach(\App\Models\Kategori::all() as $genre)
            <button @click="filterByGenre('{{ $genre->nama_kategori }}')" 
                    :class="selectedGenre === '{{ $genre->nama_kategori }}' 
                        ? 'bg-blue-600 text-white font-bold shadow-md shadow-blue-500/20 ring-1 ring-blue-500 dark:bg-blue-500' 
                        : 'bg-gray-50 dark:bg-gray-800/40 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 border border-gray-200 dark:border-gray-700'"
                    class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold rounded-lg cursor-pointer transition-all duration-200 ease-in-out border-none outline-none select-none">
                {{ $genre->nama_kategori }}
            </button>
        @endforeach
    </div>

</div>

<style>
    /* 🛠️ SINKRONISASI SPACE KOSONG SEBELAH KANAN GRID */
    .fi-ta-content-grid {
        display: grid !important;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)) !important;
        gap: 1.5rem !important; 
        width: 100% !important;
        max-width: 100% !important;
        padding-bottom: 3rem !important;
        align-items: stretch !important;
    }
    
    .fi-ta-content-grid-wrapper,
    .fi-ta-content-grid-item {
        width: 100% !important;
        max-width: 100% !important;
        height: 100% !important;
        border-radius: 0.75rem !important;
        overflow: hidden !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .fi-ta-content-grid-item:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1) !important;
        border-color: rgba(59, 130, 246, 0.4) !important;
    }

    .fi-ta-content-grid-item > div,
    .fi-ta-content-grid-item .fi-ta-col-stack {
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        height: 100% !important;
        width: 100% !important;
    }

    /* Memaksa area bungkus ViewColumn kustom kita berada di dasar paling bawah kartu */
    .fi-ta-col-stack > div:last-child {
        margin-top: auto !important;
        display: block !important;
        width: 100% !important;
    }

    body {
        overflow-y: auto !important;
    }
</style>