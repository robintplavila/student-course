<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = [
            [
                'role_key' => 'super_admin',
                'role_name' => 'Super Admin',
            ],
            [
                'role_key' => 'student',
                'role_name' => 'Student',
            ],            
            [
                'role_key' => 'hr_admin',
                'role_name' => 'HR Admin',
            ],
        ];

        foreach ($roles as $role) {            
            UserRole::create($role);
        }
    }
}
