<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TindakLanjut>
 */
class TindakLanjutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'id_rapat' => $this->faker->unique()->uuid,
        'judul_tugas' => $this->faker->sentence,
        'deadline_tugas' => $this->faker->dateTime,
        'deskripsi_tugas' => $this->faker->text,
        'status_tugas' => $this->faker->randomElement(['pending', 'completed']),
        'file_path' => $this->faker->filePath,
    ];
    }
}
