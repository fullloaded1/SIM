@php
    // Ambil data buku riil beserta relasinya dari database MySQL kamu
    $allBuku = \App\Models\Buku::with(['kategori', 'penulis'])->get();
    $allKategori = \App\Models\Kategori::all();
    $emojis = ['🌈', '🧠', '⚛️', '🌏', '🔭', '💰', '🏜️', '🤖', '💭', '✨'];
@endphp

<div x-data="{ 
    selectedCat: 'semua',
    searchQuery: '',
    showToast: false,
    toastMsg: '',
    triggerAction(msg) {
        this.toastMsg = msg;
        this.showToast = true;
        setTimeout(() => { this.showToast = false; }, 2500);
    }
}" 
style="width: 100%; margin-top: 16px; padding: 24px; background: #FFFFFF; border-radius: 16px; color: #1A1A18; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; box-sizing: border-box; box-shadow: 0 4px 16px rgba(0,0,0,0.05);">

    <div x-show="showToast" x-transition style="position: fixed; top: 30px; left: 50%; transform: translateX(-50%); background: #534AB7; color: white; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 500; z-index: 99999; box-shadow: 0 4px 12px rgba(0,0,0,0.15); display: none;" x-text="toastMsg"></div>

    <div style="max-width: 960px; margin: 0 auto;">
        
        <div style="display: flex; gap: 8px; max-width: 450px; margin-bottom: 1.5rem;">
            <input type="text" x-model="searchQuery" placeholder="Cari judul, penulis, atau topik..." style="flex: 1; padding: 10px 14px; border-radius: 8px; border: 1px solid rgba(0,0,0,0.18); font-size: 14px; background: white; color: #1A1A18; outline: none;" />
        </div>

        <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 1.5rem;">
            <button @click="selectedCat = 'semua'" :class="selectedCat === 'semua' ? 'chip-active' : 'chip-inactive'">Semua</button>
            @foreach($allKategori as $kategori)
                <button @click="selectedCat = '{{ $kategori->nama_kategori }}'" 
                        :class="selectedCat === '{{ $kategori->nama_kategori }}' ? 'chip-active' : 'chip-inactive'">
                    {{ $kategori->nama_kategori }}
                </button>
            @endforeach
        </div>

        <style>
            .chip-active { background: #EEEDFE !important; border: 0.5px solid #AFA9EC !important; color: #26215C !important; font-weight: 500; padding: 6px 14px; font-size: 13px; border-radius: 100px; cursor: pointer; }
            .chip-inactive { background: #FFFFFF !important; border: 0.5px solid rgba(0,0,0,0.1) !important; color: #6B6A65 !important; padding: 6px 14px; font-size: 13px; border-radius: 100px; cursor: pointer; transition: 0.15s; }
            .chip-inactive:hover { border-color: rgba(0,0,0,0.25); color: #1A1A18; }
        </style>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 14px;">
            @forelse($allBuku as $idx => $buku)
                @php
                    // Ambil string kategori-kategori buku untuk filter Alpine
                    $kategoriList = $buku->kategori->pluck('nama_kategori')->toArray();
                    $kategoriJson = json_encode($kategoriList);
                    
                    $judulLower = strtolower($buku->judul);
                    $penulisLower = strtolower($buku->penulis->nama_penulis ?? '');
                @endphp

                <div x-show="(selectedCat === 'semua' || {{ $kategoriJson }}.includes(selectedCat)) && (searchQuery === '' || '{{ $judulLower }}'.includes(searchQuery.toLowerCase()) || '{{ $penulisLower }}'.includes(searchQuery.toLowerCase()))"
                     style="background: #FFFFFF; border: 0.5px solid rgba(0,0,0,0.1); border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    
                    <div style="height: 135px; display: flex; align-items: center; justify-content: center; font-size: 48px; position: relative; background: #EEEDFE;">
                        @if($buku->gambar_sampul)
                            <img src="{{ asset('storage/' . $buku->gambar_sampul) }}" style="width: 100%; height: 100%; object-fit: cover;" />
                        @else
                            {{ $emojis[$idx % count($emojis)] }}
                        @endif
                        <span style="position: absolute; top: 10px; right: 10px; font-size: 10px; font-weight: 600; padding: 3px 9px; border-radius: 100px; {{ $buku->stok_tersedia <= 0 ? 'background: #FAECE7; color: #993C1D;' : 'background: #EAF3DE; color: #3B6D11;' }}">
                            {{ $buku->stok_tersedia <= 0 ? 'Dipinjam' : 'Tersedia' }}
                        </span>
                    </div>

                    <div style="padding: 10px 12px 12px; flex: 1; display: flex; flex-direction: column;">
                        <div style="font-size: 13px; font-weight: 700; color: #1A1A18; margin-bottom: 2px; line-height: 1.35;">{{ $buku->judul }}</div>
                        <div style="font-size: 11px; color: #9B9A95; margin-bottom: 6px;">{{ $buku->penulis->nama_penulis ?? 'Anonim' }}</div>
                        
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; margin-top: auto;">
                            <span style="font-size: 12px; font-weight: 600; color: #BA7517;">Rp 65.000</span>
                            <span style="font-size: 11px; color: #9B9A95;">Stok: {{ $buku->stok_tersedia }}</span>
                        </div>

                        <div style="display: flex; gap: 5px;">
                            <button @click="triggerAction('📚 Permintaan pinjam \'' + '{{ addslashes($buku->judul) }}' + '\' dikirim!')" 
                                    :disabled="{{ $buku->stok_tersedia <= 0 ? 'true' : 'false' }}"
                                    style="flex: 1; padding: 6px 0; font-size: 11px; font-weight: 500; border-radius: 6px; border: 0.5px solid #AFA9EC; background: #EEEDFE; color: #26215C; cursor: pointer;">
                                Pinjam
                            </button>
                            <button @click="triggerAction('🛒 \'' + '{{ addslashes($buku->judul) }}' + '\' masuk keranjang!')" 
                                    style="flex: 1; padding: 6px 0; font-size: 11px; font-weight: 500; border-radius: 6px; border: 0.5px solid #EF9F27; background: #FAEEDA; color: #633806; cursor: pointer;">
                                Beli
                            </button>
                        </div>
                    </div>

                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; color: #9B9A95; padding: 20px;">Belum ada koleksi buku di database perpustakaan.</div>
            @endforelse
        </div>

    </div>
</div>