<?php

namespace Tests\Feature\Api;

use App\Models\Responsible;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_student()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $responsible = Responsible::factory()->create();
        $this->actingAs($admin, 'sanctum');

        $response = $this->postJson('/api/student/create', [
            'name' => 'Estudiante Prueba',
            'last_name' => 'Prueba Apellido',
            'birth_date' => '2010-01-01',
            'responsible_id' => $responsible->id,
        ]);

        $response->assertStatus(201)->assertJsonFragment(['name' => 'Estudiante Prueba']);
    }
}