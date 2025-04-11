<?php

namespace Tests\Feature\Api;

use App\Models\Academy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_academy()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin, 'sanctum');

        $response = $this->postJson('/api/academy/create', [
            'name' => 'Prueba Academia',
            'phone_number' => '1234567890',
        ]);

        $response->assertStatus(201)->assertJson([
            'data' => ['name' => 'Prueba Academia']
        ]);
    }
}