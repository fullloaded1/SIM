<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            // Menambahkan kolom genre setelah kolom judul
        $table->string('genre')->nullable()->after('judul');
    });
}

public function down(): void
{
    Schema::table('buku', function (Blueprint $table) {
        $table->dropColumn('genre');
    });
}
};
