<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear 5 profesores (cada uno con su usuario con rol 'teacher')
        $teachers = collect();
        for ($i = 0; $i < 5; $i++) {
            $user = User::factory()->create();
            $user->assignRole('teacher');
            $teacher = Teacher::factory()->create(['user_id' => $user->id]);
            $teachers->push($teacher);
        }

        $this->command->info("✓ 5 profesores creados.");

        // 2. Crear 10 cursos distribuidos entre los profesores
        $courses = collect();
        for ($i = 0; $i < 10; $i++) {
            $course = Course::factory()->create([
                'teacher_id' => $teachers->random()->id,
                'status'     => 'published',
            ]);
            $courses->push($course);
        }

        $this->command->info("✓ 10 cursos creados.");

        // 3. Crear 3 lecciones por curso (30 lecciones en total)
        foreach ($courses as $position => $course) {
            Lesson::factory(3)->create([
                'course_id' => $course->id,
            ]);
        }

        $this->command->info("✓ 30 lecciones creadas (3 por curso).");

        // 4. Crear 20 estudiantes (cada uno con su usuario con rol 'student')
        $students = collect();
        for ($i = 0; $i < 20; $i++) {
            $user = User::factory()->create();
            $user->assignRole('student');
            $student = Student::factory()->create(['user_id' => $user->id]);
            $students->push($student);
        }

        $this->command->info("✓ 20 estudiantes creados.");

        // 5. Crear matrículas: cada estudiante se matricula en 1-3 cursos aleatorios
        foreach ($students as $student) {
            $randomCourses = $courses->random(rand(1, 3));
            foreach ($randomCourses as $course) {
                // Evitar duplicados (un alumno no puede matricularse dos veces en el mismo curso)
                $alreadyEnrolled = Enrollment::where('student_id', $student->id)
                    ->where('course_id', $course->id)
                    ->exists();

                if (! $alreadyEnrolled) {
                    $enrollment = Enrollment::create([
                        'student_id'  => $student->id,
                        'course_id'   => $course->id,
                        'enrolled_at' => now()->subDays(rand(1, 180)),
                        'status'      => fake()->randomElement(['active', 'completed', 'dropped']),
                        'final_grade' => fake()->optional(0.6)->randomFloat(2, 0, 10),
                    ]);

                    // 6. Crear un pago para cada matrícula activa o completada
                    if (in_array($enrollment->status, ['active', 'completed'])) {
                        Payment::create([
                            'student_id'     => $student->id,
                            'course_id'      => $course->id,
                            'enrollment_id'  => $enrollment->id,
                            'amount'         => $course->price,
                            'currency'       => 'EUR',
                            'status'         => 'paid',
                            'provider'       => fake()->randomElement(['stripe', 'paypal']),
                            'transaction_id' => fake()->uuid(),
                            'paid_at'        => $enrollment->enrolled_at,
                        ]);
                    }
                }
            }
        }

        $this->command->info("✓ Matrículas y pagos creados.");
        $this->command->info("✓ Demo data completada correctamente.");
    }
}
