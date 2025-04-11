<?php

namespace Tests\Feature\Api;

use App\Models\Comunication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComunicationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_send_email()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $comunication = Comunication::factory()->create();
        $this->actingAs($admin, 'sanctum');

        $response = $this->getJson("/api/comunication/resend/{$comunication->id}");

        $response->assertStatus(200)->assertJsonFragment([
            'message' => 'El comunicado ha sido enviado exitosamente.'
        ]);
    }
}