<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => fake()->unique()->numerify('#######'),
            'name' => fake()->name(),
            'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'tgl_lahir' => fake()->date(),
            'alamat' => fake()->address(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('secret'),
            'role_id' => mt_rand(1, 2),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
