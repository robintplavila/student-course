<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRole;
use App\Models\User;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        
        foreach(range(1, 10) as $index) {
            $firstName = fake()->firstName;
            $lastName = fake()->lastName;
            User::create([
                'name' => $firstName.' '.$lastName,
                'first_name' => $firstName,
                'family_name' => $lastName,
                'date_of_birth' => '1990-04-07',
                'email' => fake()->unique()->safeEmail(),
                'role_id' => UserRole::where('role_key', '=', 'student')->first()->id,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);        
        
        }
    }
}
