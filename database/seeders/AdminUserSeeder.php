<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador
        $admin = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@ghostnote.local')],
            [
                'name' => env('ADMIN_NAME', 'Administrador'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin123')),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        // Asignar rol de administrador
        $adminRole = Role::where('name', 'admin')->first();
        
        if ($adminRole && !$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
            $this->command->info('Usuario administrador creado y rol asignado.');
        } else {
            $this->command->info('Usuario administrador ya existe.');
        }

        $this->command->warn('Credenciales de administrador:');
        $this->command->warn('Email: ' . $admin->email);
        $this->command->warn('Password: ' . env('ADMIN_PASSWORD', 'admin123'));
        $this->command->warn('¡IMPORTANTE! Cambia la contraseña después del primer login.');
    }
}
