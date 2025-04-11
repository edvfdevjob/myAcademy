<?php

namespace Tests\Feature\Api;

use App\Models\Payment;
use App\Models\Student;
use App\Models\Course;
use App\Models\Registration;
use App\Models\Responsible;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_responsible_can_create_payment()
    {
        $responsible = \App\Models\Responsible::factory()->create();
        $user = $responsible->user;
        $student = Student::factory()->create(['responsible_id' => $responsible->id]);
        $course = Course::factory()->create();
        $registration = Registration::factory()->create([
            'student_id' => $student->id,
            'course_id' => $course->id,
        ]);

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/payment/create', [
            'registration_id' => $registration->id,
            'method' => 'cash',
            'payment_date' => '2024-02-02',
            'amount' => 150.00,
        ]);

        $response->assertStatus(201)->assertJsonFragment(['amount' => 150.00]);
    }
}