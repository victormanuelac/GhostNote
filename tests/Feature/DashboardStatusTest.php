<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Secret;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_status_returns_json()
    {
        $user = User::factory()->create();
        $secret = Secret::create([
            'content' => 'encrypted',
            'user_id' => $user->id,
            'max_views' => 1,
        ]);

        $response = $this->actingAs($user)->getJson(route('dashboard.status'));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => [
                         'id',
                         'created_at_human',
                         'viewed_at_human',
                         'expiration_human',
                         'is_burned',
                         'viewed_at',
                         'confirm_url',
                     ]
                 ]);
    }
}
