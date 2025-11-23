<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrador',
                'description' => 'Usuario con acceso completo al sistema. Puede gestionar usuarios, ver todos los secretos y acceder al panel de administración.',
            ],
            [
                'name' => 'user',
                'display_name' => 'Usuario',
                'description' => 'Usuario estándar con acceso limitado. Puede crear y gestionar sus propios secretos.',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name']],
                $roleData
            );
        }

        $this->command->info('Roles creados exitosamente.');
    }
}
