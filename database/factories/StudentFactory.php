<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\UserRole;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstName;
        $lastName = fake()->lastName;
        return [
            'name' => $firstName.' '.$lastName,
            'first_name' => $firstName,
            'family_name' => $lastName,
            'date_of_birth' => '1990-04-07',
            'email' => fake()->unique()->safeEmail(),
            'role_id' => UserRole::where('role_key', '=', 'student')->first()->id,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }
}
