<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Matemáticas - 4º ESO',
            'Física y Química - 1º Bachillerato',
            'Lengua Castellana y Literatura - 2º Bachillerato',
            'Historia de España - 2º Bachillerato',
            'Biología y Geología - 3º ESO',
            'Inglés y Apoyo Escolar - ESO',
            'Economía de la Empresa - 2º Bachillerato',
            'Desarrollo Web con Laravel y Livewire',
            'Master en React y Node.js',
            'Diseño UI/UX con Figma',
            'Ciberseguridad para principiantes'
        ];

        $title = $this->faker->randomElement($titles) . ' - ' . $this->faker->numberBetween(1, 99);

        $isClassroom = $this->faker->boolean(50); // 50% chance of classroom-based tutoring

        $scope = 'profesional';
        if (str_contains($title, 'ESO') || str_contains($title, 'Bachillerato') || str_contains($title, 'Escolar')) {
            $scope = 'escolar';
        }

        return [
            'teacher_id' => \App\Models\Teacher::factory(),
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title) . '-' . uniqid(),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomFloat(2, 45, 120),
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
            'is_classroom' => $isClassroom,
            'schedule' => $isClassroom ? $this->faker->randomElement(['Lunes y Miércoles 16:30-18:00', 'Martes y Jueves 17:00-18:30', 'Lunes y Miércoles 18:30-20:00']) : null,
            'classroom_pass_code' => $isClassroom ? 'PASS-' . strtoupper($this->faker->bothify('##??')) : null,
            'scope' => $scope,
        ];
    }
}
