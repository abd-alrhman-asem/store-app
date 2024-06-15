<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'date_of_birth' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'address' => (
                $this->faker->postcode .
                $this->faker->country .
                $this->faker->city
            ),
            'ip_address' => $this->faker->ipv4,
            'remember_token' => Str::random(10),
        ];
    }

}
