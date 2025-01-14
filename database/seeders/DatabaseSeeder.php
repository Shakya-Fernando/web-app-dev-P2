<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // database/seeders/DatabaseSeeder.php

    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            CoursesTableSeeder::class,
            AssessmentsTableSeeder::class,
        ]);
    }

}
