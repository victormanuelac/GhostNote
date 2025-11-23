<?php

namespace Tests\Feature;

use App\Models\Secret;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class SecretFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_secret_lifecycle()
    {
        $user = \App\Models\User::factory()->create();

        // 1. Create Secret
        $response = $this->actingAs($user)->postJson('/api/secrets', [
            'content' => 'My super secret message',
            'max_views' => 1,
        ]);

        $response->assertStatus(201);
        $id = $response->json('id');

        // 2. Verify Encrypted in DB
        $secret = Secret::find($id);
        $this->assertNotEquals('My super secret message', $secret->content);
        $this->assertEquals('My super secret message', Crypt::decryptString($secret->content));

        // 3. Access the link (Confirm page)
        $response = $this->get(route('secret.confirm', $id));
        $response->assertStatus(200);

        // 3. Confirm & Reveal (JSON)
        $response = $this->postJson(route('secret.show', ['id' => $id]));
        
        $response->assertStatus(200)
                 ->assertJson([
                     'content' => 'My super secret message'
                 ]);

        // 4. Verify Burned (Second Access)
        // 5. Access the link again -> Should be 404
        $response = $this->post(route('secret.show', $id));
        $response->assertStatus(404);
    }
}
