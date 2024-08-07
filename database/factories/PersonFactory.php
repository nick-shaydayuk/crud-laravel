<?php

namespace Database\Factories;

use App\States\Active;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'gender' => 'female',
            'birthday' => date_format(date_create('2013-03-15'), 'Y/m/y'),
            'state' => Active::class,
            'avatar' => null,
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
