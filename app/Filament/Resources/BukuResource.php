<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BukuResource\Pages;
use App\Models\Buku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload; 
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Builder;

class BukuResource extends Resource
{
    protected static ?string $model = Buku::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Katalog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('id_buku')
                        ->label('ID Buku')
                        ->required()
                        ->placeholder('Contoh: BK007')
                        ->maxLength(15)
                        ->disabledOn('edit'),

                    TextInput::make('judul')
                        ->label('Judul Buku')
                        ->required()
                        ->maxLength(200),

                    FileUpload::make('foto_buku')
                        ->label('Cover / Foto Buku')
                        ->image()
                        ->disk('public') 
                        ->directory('cover-buku') 
                        ->maxSize(1024) 
                        ->columnSpanFull(),

                    Select::make('id_kategori')
                        ->relationship('kategori', 'nama_kategori')
                        ->label('Kategori Buku')
                        ->preload()
                        ->searchable()
                        ->required(),
                    
                    Select::make('penulis')
                        ->relationship('penulis', 'nama_penulis')
                        ->label('Penulis / Pengarang')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->required()
                        ->createOptionForm([
                            TextInput::make('id_penulis')
                                ->label('ID Penulis')
                                ->required()
                                ->placeholder('Contoh: PNL001')
                                ->maxLength(15),
                                
                            TextInput::make('nama_penulis')
                                ->label('Nama Penulis Baru')
                                ->required()
                                ->maxLength(255),
                        ]),

                    TextInput::make('penerbit')
                        ->label('Penerbit')
                        ->maxLength(100),

                    TextInput::make('tahun_terbit')
                        ->label('Tahun Terbit')
                        ->numeric(),
                    
                    TextInput::make('stok')
                        ->label('Total Stok')
                        ->numeric()
                        ->required()
                        ->default(0),

                    TextInput::make('stok_tersedia')
                        ->label('Stok Tersedia')
                        ->numeric()
                        ->required()
                        ->default(0),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $kategoriUrl = request()->query('kategori', 'semua');

                if ($kategoriUrl !== 'semua') {
                    return $query->whereHas('kategori', function ($q) use ($kategoriUrl) {
                        $q->where('nama_kategori', $kategoriUrl);
                    });
                }

                return $query;
            })
            ->contentGrid([
                'sm' => 2,
                'md' => 3,
                'lg' => 4,
                'xl' => 4, 
            ])
            ->columns([
                Stack::make([
                    // ⚡ FIX LAYOUT VISUAL: Mengunci tinggi gambar cover secara konstan & membiarkan width melebar memenuhi box secara natural
                    Tables\Columns\ImageColumn::make('foto_buku')
                        ->label('Cover')
                        ->state(function ($record) {
                            if ($record->foto_buku) {
                                return asset('storage/' . $record->foto_buku);
                            }
                            return null;
                        })
                        ->defaultImageUrl(url('https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=400&auto=format&fit=crop&q=60')) 
                        ->height(260) // Mengunci tinggi cover ideal
                        ->width(null)  // Membebaskan width agar otomatis full memenuhi grid
                        ->extraAttributes(['class' => 'rounded-t-xl overflow-hidden object-cover block w-full']),

                    TextColumn::make('judul')
                        ->searchable()
                        ->weight('bold')
                        ->size('md')
                        ->limit(32)
                        ->extraAttributes(['class' => 'mt-4 block text-gray-900 dark:text-white leading-tight font-extrabold px-3.5 line-clamp-2 min-h-[2.5rem]']),

                    TextColumn::make('penulis.nama_penulis')
                        ->label('Penulis')
                        ->badge()
                        ->color('info')
                        ->extraAttributes(['class' => 'mt-1.5 px-3.5 inline-block']),

                    TextColumn::make('kategori.nama_kategori')
                        ->label('Kategori')
                        ->formatStateUsing(fn ($state) => 'Kategori: ' . $state)
                        ->color('gray')
                        ->size('xs')
                        ->extraAttributes(['class' => 'mt-2 block text-slate-400 dark:text-gray-400 px-3.5']),

                    TextColumn::make('penerbit')
                        ->formatStateUsing(fn ($record) => 'Penerbit: ' . ($record->penerbit ?? '-') . ' (' . ($record->tahun_terbit ?? '-') . ')')
                        ->size('xs')
                        ->color('gray')
                        ->extraAttributes(['class' => 'px-3.5 text-[11px] block mt-1 text-gray-400']),

                    TextColumn::make('stok_tersedia')
                        ->icon('heroicon-o-circle-stack')
                        ->formatStateUsing(fn ($state) => ($state ?? 0) . ' Unit Tersedia')
                        ->color(fn ($state) => $state <= 2 ? 'danger' : 'success') 
                        ->size('xs')
                        ->extraAttributes(['class' => 'mt-2 mb-4 block px-3.5 font-semibold']),

                    ViewColumn::make('id_buku')
                        ->view('filament.widgets.tombol-tiga-serangkai')
                        ->extraAttributes(['class' => 'w-full block mt-auto wrap-tombol-induk']),
                ])->extraAttributes(['class' => 'bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden flex flex-col justify-between h-full min-h-[460px] transition duration-200 hover:shadow-md']),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBukus::route('/'),
            'create' => Pages\CreateBuku::route('/create'),
            'edit' => Pages\EditBuku::route('/{record}/edit'),
        ];
    }
}