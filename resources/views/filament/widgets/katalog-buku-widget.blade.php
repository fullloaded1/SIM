<style>
    /* ⚡ TRICK SAKTI: Sembunyikan tabel kaku Filament agar menyisakan Grid Kustom kita */
    .fi-ta-ctn, .fi-ta-header, .fi-ta-content, .fi-ta-selection-indicator, .fi-ta-empty-state {
        display: none !important;
    }
</style>

<x-filament-widgets::widget>
    <div x-data="{ selectedGenre: 'semua' }" class="p-6 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 shadow-sm w-full">

        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🔥</span>
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Buku Favorit Perpustakaan</h2>
            </div>
            <a href="{{ \App\Filament\Resources\BukuResource::getUrl('index') }}" class="text-xs text-blue-500 hover:underline no-underline">Lihat semua ➔</a>
        </div>

        <div class="flex gap-2 flex-wrap mb-6">
            <button @click="selectedGenre = 'semua'" 
                    :class="selectedGenre === 'semua' ? 'bg-blue-600 text-white font-semibold' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700'"
                    class="px-4 py-2 text-xs rounded-lg border-none cursor-pointer transition">
                Semua
            </button>
            
            @foreach(\App\Models\Kategori::all() as $genre)
                <button @click="selectedGenre = '{{ $genre->nama_kategori }}'" 
                        :class="selectedGenre === '{{ $genre->nama_kategori }}' ? 'bg-blue-600 text-white font-semibold' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700'"
                        class="px-4 py-2 text-xs rounded-lg border-none cursor-pointer transition">
                    {{ $genre->nama_kategori }}
                </button>
            @endforeach
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 gap-4 w-full">
            @forelse(\App\Models\Buku::with(['penulis', 'kategori'])->get() as $buku)
                @php
                    $kategoriList = $buku->kategori->pluck('nama_kategori')->toArray();
                    $kategoriJson = json_encode($kategoriList);
                @endphp

                <div x-show="selectedGenre === 'semua' || {{ $kategoriJson }}.includes(selectedGenre)"
                     class="bg-white dark:bg-gray-950 rounded-xl border border-gray-200 dark:border-gray-800/80 overflow-hidden flex flex-col transition duration-300 hover:-translate-y-1 hover:shadow-lg relative min-h-[440px] justify-between">
                    
                    <div class="h-48 w-full flex items-center justify-center relative bg-gray-100 dark:bg-gray-800/50 overflow-hidden border-b border-gray-100 dark:border-gray-800">
                        @if($buku->gambar_sampul)
                            <img src="{{ asset('storage/' . $buku->gambar_sampul) }}" class="w-full h-full object-cover" />
                        @else
                            <div class="text-5xl">📚</div>
                        @endif
                    </div>

                    <div class="p-3 flex flex-col flex-grow justify-between">
                        <div>
                            <div class="text-xs font-bold text-gray-800 dark:text-gray-200 line-clamp-2 leading-tight">
                                {{ $buku->judul }}
                            </div>
                            <div class="text-[11px] text-gray-400 mt-1">
                                oleh {{ $buku->penulis->nama_penulis ?? 'Anonim' }}
                            </div>
                        </div>

                        <div class="flex gap-1 flex-wrap mt-2">
                            @foreach($buku->kategori as $kat)
                                <span class="bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-[9px] px-2 py-0.5 rounded-md font-medium border border-blue-100 dark:border-blue-900/50">
                                    {{ $kat->nama_kategori }}
                                </span>
                            @endforeach
                        </div>

                        <div class="mt-3 pt-2 border-t border-gray-100 dark:border-gray-800/60 flex flex-col gap-1 text-[11px]">
                            <div class="text-orange-500 dark:text-orange-400 font-medium">
                                Sewa: <span class="font-bold">Rp 5.000</span>
                            </div>
                            <div class="text-emerald-500 dark:text-emerald-400 font-semibold flex items-center gap-1">
                                💾 <span>{{ $buku->stok_tersedia ?? 0 }} Unit Tersedia</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1.5 mt-3 pt-2 border-t border-gray-100 dark:border-gray-800/40 w-full">
                            <a href="{{ \App\Filament\Resources\PeminjamanResource::getUrl('create') }}?id_buku={{ $buku->id_buku }}" 
                               class="w-full py-1.5 text-center text-[11px] font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition no-underline shadow-sm block cursor-pointer">
                                🤝 Pinjam Buku
                            </a>

                            <div class="flex justify-between items-center text-[11px] px-0.5 mt-0.5">
                                <a href="{{ \App\Filament\Resources\BukuResource::getUrl('edit', ['record' => $buku->id_buku]) }}" 
                                   class="text-amber-500 hover:text-amber-600 font-bold flex items-center gap-1 no-underline transition">
                                    📝 Edit
                                </a>
                                
                                <button type="button"
                                        onclick="if(confirm('Apakah kamu yakin ingin menghapus buku {{ $buku->judul }}?')) { 
                                                     Livewire.find('{{ $this->getId() }}').deleteRecord({{ $buku->id_buku }}); 
                                                 }"
                                        class="text-rose-500 hover:text-rose-600 font-bold flex items-center gap-1 border-none bg-transparent cursor-pointer transition p-0">
                                    🗑️ Delete
                                </button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-400 py-12 text-xs"> Belum ada data buku yang tersedia. </div>
            @endforelse
        </div>

    </div>
</x-filament-widgets::widget>