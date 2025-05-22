<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\rapat>
 */
class RapatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'judul_rapat' => $this->faker->sentence,
            'tanggal_rapat' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'waktu_rapat' => $this->faker->time,
            'lokasi_rapat' =>$this->faker->address,
            'kategori_rapat' => $this->faker->randomElement([
            'Rapat Internal',
            'Rapat Eksternal',
        ]),
        'id_user' => User::factory(), 
        ];
    }
}
