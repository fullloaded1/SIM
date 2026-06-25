<div class="p-3 border-t border-gray-100 dark:border-gray-800/60 bg-gray-50/40 dark:bg-gray-900/40 w-full block">
    <div class="grid grid-cols-3 gap-2 w-full text-center text-[11px] font-bold">
        
        <a href="{{ \App\Filament\Resources\BukuResource::getUrl('edit', ['record' => $getRecord()->id_buku]) }}" 
           class="w-full py-1.5 text-white bg-amber-500 hover:bg-amber-600 rounded-lg transition no-underline shadow-sm flex items-center justify-center cursor-pointer">
            Edit
        </a>
        
        <a href="{{ \App\Filament\Resources\PeminjamanResource::getUrl('create') }}?id_buku={{ $getRecord()->id_buku }}" 
           class="w-full py-1.5 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition no-underline shadow-sm flex items-center justify-center cursor-pointer">
            Pinjam Buku
        </a>
        
        <button type="button"
                onclick="if(confirm('Apakah kamu yakin ingin menghapus buku {{ $getRecord()->judul }}?')) { 
                             Livewire.find('{{ $this->getId() }}').deleteRecord({{ $getRecord()->id_buku }}); 
                         }"
                class="w-full py-1.5 text-white bg-rose-600 hover:bg-rose-700 rounded-lg transition border-none shadow-sm flex items-center justify-center cursor-pointer font-bold text-[11px]">
            Delete
        </button>
        
    </div>
</div>