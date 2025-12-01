<?php
// File: database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus semua user yang ada (optional, hati-hati di production!)
        User::truncate();

        // 1. Super Admin
        User::create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin'
        ]);

        // 2. Casemix User
        User::create([
            'name' => 'Casemix User',
            'username' => 'casemix',
            'password' => Hash::make('casemix123'),
            'role' => 'casemix'
        ]);

        // 3. Keuangan User
        User::create([
            'name' => 'Keuangan User',
            'username' => 'keuangan',
            'password' => Hash::make('keuangan123'),
            'role' => 'keuangan'
        ]);

        $this->command->info('✅ Berhasil membuat 3 user!');
        $this->command->info('   - admin / admin123 (Super Admin)');
        $this->command->info('   - casemix / casemix123 (Casemix)');
        $this->command->info('   - keuangan / keuangan123 (Keuangan)');

        // Jalankan seeder klaim
        $this->call([
            KlaimSeeder::class,
        ]);
    }
}