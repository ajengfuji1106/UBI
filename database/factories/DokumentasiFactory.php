<?php

namespace Database\Factories;

use App\Models\Rapat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dokumentasi>
 */
class DokumentasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_rapat' => Rapat::factory(),
            'judul_dokumentasi' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
        ];
    }
}
