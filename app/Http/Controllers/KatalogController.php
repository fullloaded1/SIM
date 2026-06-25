<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Query mencari buku berdasarkan judul ATAU nama penulisnya
        $hasilBuku = Buku::query()
            ->where('judul', 'LIKE', "%{$keyword}%")
            ->orWhereHas('penulis', function ($query) use ($keyword) {
                $query->where('nama_penulis', 'LIKE', "%{$keyword}%");
            })
            ->get();

        // Lempar hasil pencarian ke view blade baru (misal: search-result.blade.php)
        return view('search-result', compact('hasilBuku', 'keyword'));
    }
}