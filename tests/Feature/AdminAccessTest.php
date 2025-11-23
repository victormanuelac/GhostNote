<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear roles
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        // Crear usuario admin
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
        ]);
        $admin->assignRole('admin');

        // Intentar acceder al dashboard de admin
        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Panel de Administración');
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        // Crear usuario regular
        $user = User::factory()->create();
        $user->assignRole('user');

        // Intentar acceder al dashboard de admin
        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_users_list(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('Gestión de Usuarios');
    }

    public function test_user_model_has_role_methods(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->assertTrue($user->hasRole('user'));
        $this->assertFalse($user->hasRole('admin'));
        $this->assertFalse($user->isAdmin());

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->assertTrue($admin->hasRole('admin'));
        $this->assertTrue($admin->isAdmin());
    }
}
