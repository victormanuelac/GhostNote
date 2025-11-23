<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear roles primero
        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,
        ]);

        // Crear usuario de prueba (opcional)
        // User::factory(10)->create();
    }
}
