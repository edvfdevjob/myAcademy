<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Academy;
use App\Models\Course;
use App\Models\Responsible;
use App\Models\Student;
use App\Models\Registration;
use App\Models\Payment;
use App\Models\Comunication;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

            User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@myacademy.com',
                'role' => 'admin'
            ]);

            Responsible::factory(5)->create(['user_id' => User::factory()->create([
                'name' => 'Responsible User',
                'email' => 'responsible@myacademy.com',
            ])]);

            Academy::factory(3)->create()->each(function ($academy) {

            $courses = Course::factory(5)->create([
                'academy_id' => $academy->id,
            ]);

            Responsible::factory(5)->create()->each(function ($responsible) use ($courses) {
                $students = Student::factory(2)->create([
                    'responsible_id' => $responsible->id,
                ]);

                foreach ($students as $student) {
                    $registrations = Registration::factory(2)->create([
                        'student_id' => $student->id,
                        'course_id' => $courses->random()->id,
                    ]);

                    foreach ($registrations as $registration) {
                        Payment::factory(rand(1, 2))->create([
                            'registration_id' => $registration->id,
                        ]);
                    }
                }
            });

            foreach ($courses as $course) {
                Comunication::factory(rand(1, 3))->create([
                    'course_id' => $course->id,
                ]);
            }
        });

        
    }
}
