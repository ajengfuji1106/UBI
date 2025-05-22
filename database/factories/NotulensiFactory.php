<?php

namespace Database\Factories;

use App\Models\Rapat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\notulensi>
 */
class NotulensiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'id_rapat' => Rapat::factory(),     // otomatis juga buat rapat
        'id_user' => User::factory(),       // otomatis juga buat user
        'judul_notulensi' => $this->faker->sentence,
        'konten_notulensi' => $this->faker->paragraph,
    ];
    }
}
