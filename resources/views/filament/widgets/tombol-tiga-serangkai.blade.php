<div class="px-4 py-3.5 border-t border-gray-100 dark:border-gray-800/80 bg-gray-50/40 dark:bg-gray-900/40 w-full block mt-auto" style="box-sizing: border-box !important;">
    
    <div style="display: grid !important; grid-template-columns: 1fr 1fr !important; gap: 8px !important; width: 100% !important; box-sizing: border-box !important;">
        
        <div style="grid-column: span 1 !important; width: 100% !important;">
            <a href="{{ \App\Filament\Resources\BukuResource::getUrl('edit', ['record' => $getRecord()->id_buku]) }}" 
               class="text-blue-600 hover:text-blue-700 bg-blue-50/60 hover:bg-blue-50 dark:text-blue-400 dark:bg-blue-950/30 dark:hover:bg-blue-950/60 rounded-lg transition-all duration-200 no-underline font-bold text-[12px]"
               style="display: flex !important; align-items: center !important; justify-content: center !important; gap: 6px !important; width: 100% !important; height: 36px !important; border: none !important; text-align: center !important; box-sizing: border-box !important;">
                <span>📝</span>
                <span>Edit</span>
            </a>
        </div>
        
        <div style="grid-column: span 1 !important; width: 100% !important;">
            <a href="{{ \App\Filament\Resources\PeminjamanResource::getUrl('create') }}?id_buku={{ $getRecord()->id_buku }}" 
               class="text-emerald-600 hover:text-emerald-700 bg-emerald-50/60 hover:bg-emerald-50 dark:text-emerald-400 dark:bg-emerald-950/30 dark:hover:bg-emerald-950/60 rounded-lg transition-all duration-200 no-underline font-bold text-[12px]"
               style="display: flex !important; align-items: center !important; justify-content: center !important; gap: 6px !important; width: 100% !important; height: 36px !important; border: none !important; text-align: center !important; box-sizing: border-box !important; whitespace: nowrap !important;">
                <span>📖</span>
                <span>Pinjam</span>
            </a>
        </div>

        <div style="grid-column: span 2 !important; width: 100% !important; margin-top: 2px !important; box-sizing: border-box !important;">
            <button type="button"
                    onclick="if(confirm('Apakah kamu yakin ingin menghapus buku {{ $getRecord()->judul }}?')) { 
                                 Livewire.find('{{ $this->getId() }}').deleteRecord({{ $getRecord()->id_buku }}); 
                             }"
                    class="w-full text-rose-600 hover:text-rose-700 bg-rose-50/60 hover:bg-rose-50 dark:text-rose-400 dark:bg-rose-950/30 dark:hover:bg-rose-950/60 rounded-lg transition-all duration-200 font-bold text-[12px]"
                    style="display: flex !important; align-items: center !important; justify-content: center !important; gap: 6px !important; width: 100% !important; height: 36px !important; border: none !important; cursor: pointer !important; text-align: center !important; box-sizing: border-box !important;">
                <span>🗑️</span>
                <span>Delete Buku</span>
            </button>
        </div>
        
    </div>
</div>