<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang | SIM Perpustakaan AHSIM</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-950 min-h-screen flex flex-col justify-between relative overflow-x-hidden">

    <!-- Ornamen Sorotan Cahaya Lembut di Latar Belakang (Sesuai Gambar EleBrary) -->
    <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-cyan-100/40 blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-amber-100/40 blur-[120px] pointer-events-none"></div>

    <!-- NAVBAR (Sinkronisasi EleBrary + Branding Kampus) -->
    <header class="w-full max-w-7xl mx-auto px-6 py-5 flex justify-between items-center relative z-10">
        <div class="flex items-center gap-3">
            <!-- Representasi Logo EleBrary dengan sentuhan Identitas AHSIM -->
            <div class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-md">
                ⬡
            </div>
            <span class="text-2xl font-extrabold tracking-tight text-slate-800">AHSIM <span class="text-cyan-500 font-medium text-lg">Perpustakaan</span></span>
        </div>
        
        <div class="flex items-center gap-6">
            <div class="hidden md:flex items-center gap-4 px-4 py-1.5 bg-gray-50 border border-gray-200 rounded-full text-xs font-semibold tracking-wide text-gray-500 shadow-sm">
                🏫 <span class="text-gray-700">STT TERPADU NURUL FIKRI</span>
            </div>
            <!-- Tombol Login Pojok Kanan Atas Sesuai Gambar -->
            <a href="/admin/login" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold px-6 py-2.5 rounded-lg shadow-lg shadow-cyan-500/20 transition tracking-wider text-sm uppercase">
                Login
            </a>
        </div>
    </header>

    <!-- HERO SECTION (Grid Kiri-Kanan Persis Image_d663ca.png) -->
    <main class="w-full max-w-7xl mx-auto px-6 pt-12 pb-24 grid md:grid-cols-2 items-center gap-12 flex-grow relative z-10">
        
        <!-- Sisi Kiri: Teks Judul Utama & Input Pencarian -->
        <div class="space-y-8">
            <!-- Tagline Kecil Atas Kelompok -->
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-cyan-500/10 border border-cyan-500/30 text-cyan-600 text-xs font-medium rounded-full uppercase tracking-widest">
                ✨ Smart Library System — Kelompok 10
            </div>

            <!-- Judul Utama Bold EleBrary Style -->
            <h1 class="text-5xl md:text-6xl font-black text-slate-900 leading-[1.15] tracking-tight">
                Sistem Informasi <br>
                <span class="text-cyan-500">Perpustakaan Digital.</span>
            </h1>

            <!-- Deskripsi Aplikasi Kelompokmu -->
            <p class="text-lg text-gray-400 max-w-md font-medium leading-relaxed">
                Kelola sirstulasi buku, data anggota, manajemen pengguna, dan kalkulasi denda keterlambatan secara otomatis, cepat, dan responsif.
            </p>

            <!-- Kolom Pencarian Buku Sesuai Gambar -->
            <form action="{{ url('/') }}" method="GET" class="flex items-center bg-gray-50 border border-gray-200 rounded-xl p-1.5 focus-within:border-cyan-500 focus-within:ring-2 focus-within:ring-cyan-500/20 transition shadow-sm w-full">
                <input 
                    type="text" 
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Search by book title, author name ..." 
                    class="w-full bg-transparent px-4 py-3 text-gray-700 outline-none placeholder:text-gray-400 font-medium"
                >
                <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-white p-3.5 rounded-lg shadow-md transition flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
            <div class="max-w-lg mx-auto mt-8">
            @if(request('search'))
                <p class="text-sm text-gray-500 mb-4">
                    Menampilkan hasil pencarian untuk kata kunci: <strong class="text-cyan-600">"{{ request('search') }}"</strong>
                </p>
            @endif

            <div class="grid grid-cols-1 gap-4">
                @forelse($books as $buku)
                    <div class="flex flex-col p-5 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">{{ $buku->judul }}</h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Penulis: 
                                    <span class="font-medium text-gray-700">
                                        {{ $buku->penulis->isNotEmpty() ? $buku->penulis->implode('nama_penulis', ', ') : 'Tidak Ada Nama' }}
                                    </span>
                                </p>
                            </div>
                            
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $buku->stok_tersedia > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                {{ $buku->stok_tersedia > 0 ? 'Tersedia: ' . $buku->stok_tersedia : 'Stok Habis' }}
                            </span>
                        </div>
                    </div>
                @empty
                    @if(request('search'))
                        <div class="p-6 bg-amber-50 border border-amber-100 rounded-2xl text-center">
                            <p class="text-amber-700 font-medium">Buku atau penulis dengan nama "{{ request('search') }}" tidak ditemukan, Pip.</p>
                        </div>
                    @endif
                @endforelse
            </div>
        </div>
        </div>

        <!-- Sisi Kanan: Ilustrasi Isometrik Premium EleBrary -->
        <div class="relative flex justify-center">
            <svg class="w-full max-w-[460px] drop-shadow-2xl animate-[float_4s_ease-in-out_infinite]" viewBox="0 0 500 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                <style>
                    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
                </style>
                <!-- Sampul Belakang Buku Besar -->
                <path d="M120 100 L380 50 L460 180 L200 230 Z" fill="#FBBF24" />
                <path d="M200 230 L460 180 L440 280 L180 330 Z" fill="#D97706" />
                <!-- Lembaran Buku Terbuka -->
                <path d="M150 140 C 220 110, 300 110, 370 140 L350 320 C 280 290, 200 290, 130 320 Z" fill="#F8FAFC" stroke="#E2E8F0" stroke-width="2" />
                <path d="M370 140 C 410 120, 440 130, 460 150 L440 320 C 420 300, 390 290, 350 320 Z" fill="#F1F5F9" />
                <!-- Garis-garis Baris Teks Buku -->
                <path d="M160 170 L240 150 M160 200 L250 180 M160 230 L230 215" stroke="#94A3B8" stroke-width="4" stroke-linecap="round" />
                <path d="M280 150 L350 165 M280 180 L340 195 M280 210 L350 225" stroke="#94A3B8" stroke-width="4" stroke-linecap="round" />
                <!-- Tumpukan Buku Berdiri Samping -->
                <rect x="260" y="210" width="35" height="110" rx="4" transform="rotate(15 260 210)" fill="#38BDF8" />
                <rect x="305" y="190" width="35" height="120" rx="4" transform="rotate(15 305 190)" fill="#FBBF24" />
                <rect x="350" y="170" width="35" height="130" rx="4" transform="rotate(15 350 170)" fill="#F43F5E" />
                <!-- Karakter Duduk Membaca Buku -->
                <circle cx="210" cy="270" r="16" fill="#FDE047" />
                <path d="M195 286 C 195 275, 225 275, 225 286 L220 340 L200 340 Z" fill="#E2E8F0" />
                <path d="M210 286 L210 320 L180 330" stroke="#1E293B" stroke-width="12" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M200 340 L200 370 L170 370" stroke="#1E293B" stroke-width="12" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="w-full text-center py-6 border-t border-gray-100 bg-gray-50 text-xs text-gray-500 tracking-wide relative z-10">
        <p>© 2026 <span class="text-gray-700 font-semibold">AHSIM Perpustakaan</span> • Developed by <span class="text-cyan-600 font-medium">Kelompok 10</span></p>
    </footer>

</body>
</html>