<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@ibam.com',
            'password' => Hash::make('password'),
            'role' => 'administrator',
        ]);

        // Create classes
        $class1 = ClassModel::create(['name' => 'Première année']);
        $class2 = ClassModel::create(['name' => 'Deuxième année']);

        // Create professors
        $professor1 = User::create([
            'name' => 'Prof. Martin',
            'email' => 'martin@ibam.com',
            'password' => Hash::make('password'),
            'role' => 'professor',
        ]);

        $professor2 = User::create([
            'name' => 'Prof. Dubois',
            'email' => 'dubois@ibam.com',
            'password' => Hash::make('password'),
            'role' => 'professor',
        ]);

        // Create students
        User::create([
            'name' => 'Jean Dupont',
            'email' => 'jean@ibam.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'class_id' => $class1->id,
        ]);

        User::create([
            'name' => 'Marie Laurent',
            'email' => 'marie@ibam.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'class_id' => $class2->id,
        ]);

        // Create schedules
        Schedule::create([
            'title' => 'Mathématiques',
            'day' => 'Lundi',
            'start_time' => '08:00',
            'end_time' => '10:00',
            'class_id' => $class1->id,
            'professor_id' => $professor1->id,
        ]);

        Schedule::create([
            'title' => 'Physique',
            'day' => 'Mardi',
            'start_time' => '10:00',
            'end_time' => '12:00',
            'class_id' => $class2->id,
            'professor_id' => $professor2->id,
        ]);
    }
}
