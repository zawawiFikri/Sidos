<?php

namespace Database\Seeders;
use App\Models\dosen;
use App\Models\User;
use App\Models\Role;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'role_name' => 'admin',
        ]);

        Role::create([
            'role_name' => 'dosen',
        ]);

        User::factory(9)->create()->each(function ($user) {
            if ($user->role_id == 2) {
                Dosen::create([
                    'user_id' => $user->id,
                    // Tambahkan atribut lainnya sesuai kebutuhan
                ]);
            }
        });
    
    }
}
