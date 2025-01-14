<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    // Seed users
    public function run()
    {
        // Create 5 teachers
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Teacher $i", 
                'email' => null,
                's_number' => "t$i", // for simplicity t1, t2, t3 etc..
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ]);
        }

        // Create 50 students
        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'name' => "Student $i",
                'email' => null,
                's_number' => "s$i", // for simplicity s1, s2, s3 etc..
                'password' => Hash::make('password'), // password is password :)
                'role' => 'student',
            ]);
        }
    }
}
