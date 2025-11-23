<?php

namespace Tests\Feature;

use App\Models\Secret;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnavailableSecretTest extends TestCase
{
    use RefreshDatabase;

    public function test_unavailable_secret_shows_correct_ui()
    {
        // Create a burned secret
        $secret = Secret::create([
            'content' => 'burned',
            'is_burned' => true,
            'max_views' => 1,
        ]);

        $response = $this->get(route('secret.confirm', $secret->id));

        $response->assertStatus(200);
        $response->assertSee('No disponible');
        $response->assertSee('Este secreto ya no existe');
        $response->assertDontSee('Sí, muéstrame el secreto');
        $response->assertSee(route('secret.burned'));
    }
}
