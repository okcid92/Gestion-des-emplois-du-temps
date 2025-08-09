<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ScheduleSeeder;
use Database\Seeders\StudentSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ClassSeeder;
use Database\Seeders\ClassAndRoomSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ClassSeeder::class,
            StudentSeeder::class,
            ScheduleSeeder::class,
            ClassAndRoomSeeder::class,
        ]);
    }
}
