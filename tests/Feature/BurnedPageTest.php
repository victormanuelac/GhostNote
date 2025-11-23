<?php

namespace Tests\Feature;

use Tests\TestCase;

class BurnedPageTest extends TestCase
{
    public function test_burned_page_is_accessible_publicly()
    {
        $response = $this->get('/burned');

        $response->assertStatus(200);
        $response->assertSee('GhostNote');
    }
}
