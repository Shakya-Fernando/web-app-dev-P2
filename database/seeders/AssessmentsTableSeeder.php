<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assessment;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class AssessmentsTableSeeder extends Seeder
{
    // Seed assessments
    public function run()
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            for ($i = 1; $i <= 5; $i++) {
                Assessment::create([
                    'course_id' => $course->id,
                    'title' => "Assessment $i",
                    'instruction' => "Instructions for Assessment $i",
                    'number_of_reviews' => rand(1, 3),
                    'max_score' => 100,
                    'due_date' => Carbon::now()->addDays(7),
                    'type' => 'student-select',
                ]);
            }
        }
    }
}
