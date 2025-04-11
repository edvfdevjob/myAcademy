<?php

namespace Tests\Feature\Api;

use App\Models\Academy;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_course()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $academy = Academy::factory()->create();
        $this->actingAs($admin, 'sanctum');

        $response = $this->postJson('/api/course/create', [
            'name' => 'Prueba Creacion Curso',
            'description' => 'Prueba descripcion',
            'price' => 200.7,
            'duration' => 120,
            'academy_id' => $academy->id
        ]);

        $response->assertStatus(201)->assertJsonFragment(['name' => 'Prueba Creacion Curso']);
    }
}