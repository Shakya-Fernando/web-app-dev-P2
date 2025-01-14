<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoursesTableSeeder extends Seeder
{
    // Seed courses
    public function run()
    {
        // Create 5 courses
        for ($i = 1; $i <= 5; $i++) {
            $course = Course::create([
                'code' => "COURSE$i",
                'name' => "Course $i",
            ]);

            // Enroll teachers to courses
            $teachers = User::where('role', 'teacher')->inRandomOrder()->take(2)->get();
            foreach ($teachers as $teacher) {
                $course->users()->attach($teacher->id, ['role' => 'teacher']);
            }

            // Enroll students to courses
            $students = User::where('role', 'student')->inRandomOrder()->take(10)->get();
            foreach ($students as $student) {
                $course->users()->attach($student->id, ['role' => 'student']);
            }
        }
    }
}
