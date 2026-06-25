<div>
    @if(isset($isKatalogPage) && $isKatalogPage)
        <div class="mb-4 w-full">
            <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 10px; width: 100%;">
                
                <button @click="window.location.search = ''" 
                        class="{{ $kategoriAktif === 'semua' ? 'cat-badge-active' : 'cat-badge-inactive' }}">
                    Semua
                </button>
                
                @foreach($genres as $genre)
                    <button @click="window.location.search = '?kategori=' + '{{ $genre->nama_kategori }}'" 
                            class="{{ $kategoriAktif === $genre->nama_kategori ? 'cat-badge-active' : 'cat-badge-inactive' }}">
                        {{ $genre->nama_kategori }}
                    </button>
                @endforeach
            </div>

            <style>
                .cat-badge-active { 
                    background: #3b82f6 !important; 
                    color: white !important; 
                    font-weight: 600; 
                    padding: 6px 14px; 
                    font-size: 12px; 
                    border-radius: 8px; 
                    border: none; 
                    cursor: pointer; 
                }
                .cat-badge-inactive { 
                    background: #f4f4f5; 
                    color: #71717a; 
                    padding: 6px 14px; 
                    font-size: 12px; 
                    border-radius: 8px; 
                    border: none; 
                    cursor: pointer; 
                    transition: 0.15s; 
                }
                .dark .cat-badge-inactive { 
                    background: #1f1f23 !important; 
                    color: #a1a1aa !important; 
                }
                .cat-badge-inactive:hover { 
                    background: #e4e4e7; 
                    color: #18181b; 
                }
                .dark .cat-badge-inactive:hover { 
                    background: #2d2d33 !important; 
                    color: white !important; 
                }
            </style>
        </div>
    @endif
</div>