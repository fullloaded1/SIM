<x-filament-widgets::widget>
    @php
        // Emoji cadangan jika gambar sampul kosong
        $emojis = ['📚', '🧠', '⚛️', '🌏', '🔭', '💰', '🏜️', '🤖', '💭', '✨'];
    @endphp

    <div x-data="{ 
        selectedGenre: 'semua',
        showToast: false,
        toastMsg: '',
        triggerAction(msg) {
            this.toastMsg = msg;
            this.showToast = true;
            setTimeout(() => { this.showToast = false; }, 2500);
        }
    }" 
    class="p-6 rounded-xl bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-900 shadow-sm"
    style="font-family: inherit;">

        <div x-show="showToast" x-transition 
             style="position: fixed; top: 30px; left: 50%; transform: translateX(-50%); background: #3b82f6; color: white; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; z-index: 99999; box-shadow: 0 4px 12px rgba(0,0,0,0.3); display: none;" 
             x-text="toastMsg">
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 20px;">🔥</span>
                <h2 style="font-size: 16px; font-weight: 700; margin: 0;" class="text-gray-900 dark:text-white">Buku Favorit</h2>
            </div>
            <a href="/admin/bukus" style="font-size: 13px; font-weight: 500; color: #3b82f6; text-decoration: none; transition: 0.2s;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                Lihat semua →
            </a>
        </div>

        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 24px;">
            <button @click="selectedGenre = 'semua'" 
                    :class="selectedGenre === 'semua' ? 'fav-badge-active' : 'fav-badge-inactive'">
                Semua
            </button>
            @foreach($genres as $genre)
                <button @click="selectedGenre = '{{ $genre->nama_kategori }}'" 
                        :class="selectedGenre === '{{ $genre->nama_kategori }}' ? 'fav-badge-active' : 'fav-badge-inactive'">
                    {{ $genre->nama_kategori }}
                </button>
            @endforeach
        </div>

        <style>
            .fav-badge-active { background: #3b82f6 !important; color: white !important; font-weight: 600; padding: 6px 14px; font-size: 12px; border-radius: 8px; border: none; cursor: pointer; }
            .fav-badge-inactive { background: #f4f4f5; color: #71717a; padding: 6px 14px; font-size: 12px; border-radius: 8px; border: none; cursor: pointer; transition: 0.15s; }
            .dark .fav-badge-inactive { background: #1f1f23 !important; color: #a1a1aa !important; }
            .fav-badge-inactive:hover { background: #e4e4e7; color: #18181b; }
            .dark .fav-badge-inactive:hover { background: #2d2d33 !important; color: white !important; }

            
            .buku-fav-card {
                cursor: pointer;
                transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease !important;
            }
            .buku-fav-card:hover {
                transform: translateY(-5px) scale(1.025);
                border-color: rgba(59, 130, 246, 0.3) !important;
                box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.15) !important;
            }
            
            
            .buku-fav-card:hover .cover-zoom-target {
                transform: scale(1.08) !important;
            }

            
            .cover-zoom-target {
                transition: transform 0.25s ease !important;
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
            }

            
            .buku-fav-card > div:first-child {
                height: 240px !important; 
                aspect-ratio: 2 / 3 !important; 
                background: rgba(59, 130, 246, 0.02) !important;
            }
        </style>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px;">
            @forelse($bukuFavorit as $idx => $buku)
                @php
                    $kategoriList = $buku->kategori->pluck('nama_kategori')->toArray();
                    $kategoriJson = json_encode($kategoriList);
                @endphp

                <div x-show="selectedGenre === 'semua' || {{ $kategoriJson }}.includes(selectedGenre)"
                     class="bg-gray-50 dark:bg-gray-900/40 buku-fav-card"
                     style="border: 1px solid rgba(128,128,128,0.1); border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; transition: 0.2s;">
                    
                    <div style="height: 150px; display: flex; align-items: center; justify-content: center; font-size: 54px; position: relative; background: rgba(59, 130, 246, 0.05); overflow: hidden;">
                        @if($buku->gambar_sampul)
                            <img src="{{ asset('storage/' . $buku->gambar_sampul) }}" class="cover-zoom-target" style="width: 100%; height: 100%; object-fit: cover;" />
                        @else
                            <div class="cover-zoom-target" style="display: inline-block;">
                                {{ $emojis[$idx % count($emojis)] }}
                            </div>
                        @endif
                        
                        <span style="position: absolute; top: 8px; right: 8px; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 6px; z-index: 10; {{ $buku->stok_tersedia <= 0 ? 'background: #fee2e2; color: #ef4444;' : 'background: #dcfce7; color: #22c55e;' }}">
                            {{ $buku->stok_tersedia <= 0 ? 'Dipinjam' : 'Tersedia' }}
                        </span>
                    </div>

                    <div style="padding: 12px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; min-height: 150px;">
                        <div>
                            <div style="font-size: 13px; font-weight: 700; margin-bottom: 4px; line-height: 1.4; opacity: 1 !important;" class="text-gray-900 dark:text-white">
                                {{ $buku->judul }}
                            </div>
                            <div style="font-size: 11px; color: #6b7280; margin-bottom: 12px;" class="dark:text-gray-400">
                                oleh {{ $buku->penulis->nama_penulis ?? 'Anonim' }}
                            </div>
                        </div>
                        
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; margin-top: auto;">
                            <div>
                                <span style="font-size: 9px; color: #71717a; display: block; margin-bottom: -2px;">Biaya Sewa</span>
                                <span style="font-size: 12px; font-weight: 700; color: #eab308;">Rp 5.000</span>
                            </div>
                            <span style="font-size: 11px; color: #71717a;">Stok: {{ $buku->stok_tersedia }}</span>
                        </div>

                        <div style="display: flex; gap: 6px; width: 100%;">
                            @if($buku->stok_tersedia <= 0)
                                <button disabled
                                        style="flex: 1; padding: 8px 0; font-size: 12px; font-weight: 600; border-radius: 6px; border: none; background: #e4e4e7; color: #a1a1aa; cursor: not-allowed; text-align: center;" class="dark:bg-gray-800 dark:text-gray-600">
                                    Dipinjam
                                </button>
                            @else
                                <a href="/admin/peminjamen/create?id_buku={{ $buku->id_buku }}" 
                                   style="flex: 1; padding: 8px 0; font-size: 12px; font-weight: 600; border-radius: 6px; border: none; background: #3b82f6; color: white; cursor: pointer; text-align: center; text-decoration: none; display: inline-block; transition: 0.15s;"
                                   onmouseover="this.style.background='#2563eb'" 
                                   onmouseout="this.style.background='#3b82f6'">
                                    Pinjam
                                </a>
                            @endif
                            
                            <a href="/admin/bukus/{{ $buku->id_buku }}/edit" 
                               style="flex: 1; padding: 8px 0; font-size: 12px; font-weight: 600; border-radius: 6px; border: 1px solid #d1d5db; background: transparent; color: #374151; cursor: pointer; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 4px; transition: 0.15s;"
                               class="dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white"
                               onmouseover="this.style.backgroundColor='rgba(0,0,0,0.02)'; this.style.borderColor='#9ca3af';" 
                               onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='#d1d5db';">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px; height: 14px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>
                                Edit
                            </a>
                        </div>

                    </div>

                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; color: #a1a1aa; padding: 30px; font-size: 13px;">
                    Belum ada data koleksi buku terpopuler saat ini.
                </div>
            @endforelse
        </div>

    </div>
</x-filament-widgets::widget>