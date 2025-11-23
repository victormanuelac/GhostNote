<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Secret;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_guests_cannot_access_dashboard()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_user_can_create_secret_from_dashboard()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/secrets', [
            'content' => 'Dashboard secret',
            'max_views' => 5,
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('created_url');
        $this->assertDatabaseHas('secrets', [
            'user_id' => $user->id,
            'max_views' => 5,
        ]);
    }

    public function test_dashboard_lists_user_secrets()
    {
        $user = User::factory()->create();
        
        $secret = Secret::create([
            'content' => 'encrypted content',
            'description' => 'Test Description',
            'user_id' => $user->id,
            'max_views' => 1,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $this->assertDatabaseHas('secrets', [
            'id' => $secret->id,
            'description' => 'Test Description',
            'user_id' => $user->id,
        ]);
    }
}
