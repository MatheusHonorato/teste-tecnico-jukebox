<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kreait\Laravel\Firebase\Facades\Firebase;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $createdUser = Firebase::auth()->createUser([
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);

        return [
            'id' => $createdUser->uid,
            'email' => $createdUser->email,
        ];
    }
}
