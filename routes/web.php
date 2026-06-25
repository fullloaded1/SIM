<?php

use Illuminate\Support\Facades\Route;
use App\Models\Buku;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    $search = $request->input('search');
    
    // Jika admin/user mencari buku di landing page
    $books = Buku::query()
        ->when($search, function ($query, $search) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhereHas('penulis', function ($q) use ($search) {
                      $q->where('nama_penulis', 'like', "%{$search}%");
                  });
        })
        ->with(['penulis'])
        ->limit(6)
        ->get();

    return view('welcome', compact('books', 'search'));
});