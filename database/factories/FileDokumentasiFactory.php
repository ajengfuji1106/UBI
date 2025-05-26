<?php

namespace Database\Factories;

use App\Models\Dokumentasi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FileDokumentasi>
 */
class FileDokumentasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_dokumentasi' => Dokumentasi::factory(),
            'file_path' => 'dokumentasi/' . $this->faker->uuid . '.jpg',
        ];
    }
}
