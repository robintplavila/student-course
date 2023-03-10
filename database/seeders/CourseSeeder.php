<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $courses = [
            [                
                'course_name' => 'Web Application Scripting',
            ],
            [                
                'course_name' => 'Database Management',
            ]
        ];

        foreach ($courses as $course) {            
            Course::create($course);
        }
    }
}