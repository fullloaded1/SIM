<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftarkan Permissions
        $permissions = [
            'manage users', 'manage buku', 'manage anggota', 
            'manage peminjaman', 'manage laporan', 'manage pengaturan',
            'view buku', 'view anggota', 'create peminjaman', 
            'update peminjaman', 'create pengembalian', 'update pengembalian', 'view laporan denda'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat Role Super Admin & berikan semua akses
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $roleSuperAdmin->syncPermissions(Permission::all());

        // Buat Role Petugas dengan hak akses terbatas
        $rolePetugas = Role::firstOrCreate(['name' => 'petugas']);
        $rolePetugas->syncPermissions([
            'view buku', 'view anggota', 
            'create peminjaman', 'update peminjaman',
            'create pengembalian', 'update pengembalian', 
            'view laporan denda'
        ]);

        // Buat Akun Default Super Admin
        $admin = User::firstOrCreate([
            'email' => 'admin@perpus.com'
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole($roleSuperAdmin);

        // Buat Akun Default Petugas
        $petugas = User::firstOrCreate([
            'email' => 'petugas@perpus.com'
        ], [
            'name' => 'Lilis Karlina',
            'password' => Hash::make('password123'),
        ]);
        $petugas->assignRole($rolePetugas);
    }
}