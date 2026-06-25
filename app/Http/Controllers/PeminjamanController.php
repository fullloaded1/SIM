<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    
    public function index(): View
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->orderBy('id_pinjam', 'desc')
            ->paginate(10);

        return view('peminjaman.index', compact('peminjaman'));
    }

    
    public function getAllDataApi(): JsonResponse
    {
        $data = Peminjaman::with(['anggota', 'buku'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar data sirkulasi peminjaman perpustakaan',
            'data'    => $data
        ], 200);
    }

    
    public function kembalikanBukuApi(int $id): JsonResponse
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'Data transaksi peminjaman tidak ditemukan'
            ], 404);
        }

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tgl_kembali' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dikembalikan dan status diperbarui',
            'data'    => $peminjaman
        ], 200);
    }
}