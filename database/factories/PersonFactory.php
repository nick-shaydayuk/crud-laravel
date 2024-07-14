<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\States\PersonState;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'gender' => fake()->name(),
            'birthday' => date_format(date_create('2013-03-15'), 'd/m/y'),
            'state' => PersonState::class,
            'avatar' => null,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
        ];
    }
}
