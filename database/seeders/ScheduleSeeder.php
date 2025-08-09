<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Schedule;
use App\Models\ClassModel;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run()
    {
        // Créer la classe Licence 2 Informatique
        $class = ClassModel::firstOrCreate([
            'name' => 'LICENCE 2'
        ]);

        // Créer les professeurs
        $profGuinko = User::firstOrCreate([
            'email' => 'guinko.ferdinand@ibam.bf'
        ], [
            'name' => 'Dr GUINKO',
            'prenom' => 'Ferdinand',
            'role' => 'professor',
            'password' => bcrypt('password')
        ]);

        $profOuattara = User::firstOrCreate([
            'email' => 'yacouba.ouattara@ibam.bf'
        ], [
            'name' => 'Dr OUATTARA',
            'prenom' => 'Yacouba',
            'role' => 'professor',
            'password' => bcrypt('password')
        ]);

        $profIlboudo = User::firstOrCreate([
            'email' => 'han.ilboudo@ibam.bf'
        ], [
            'name' => 'Dr ILBOUDO',
            'prenom' => 'Han madou',
            'role' => 'professor',
            'password' => bcrypt('password')
        ]);

        // Créer les cours
        $schedules = [
            // Lundi
            [
                'title' => 'Programmation Web dynamique',
                'professor_id' => $profGuinko->id,
                'day' => 'Monday',
                'start_time' => '07:30',
                'end_time' => '12:30',
                'room' => 'B6'
            ],
            
            // Mardi
            [
                'title' => 'Python',
                'professor_id' => $profOuattara->id,
                'day' => 'Tuesday',
                'start_time' => '07:30',
                'end_time' => '12:30',
                'room' => 'B6'
            ],
            
            // Mercredi
            [
                'title' => 'Programmation Web dynamique',
                'professor_id' => $profGuinko->id,
                'day' => 'Wednesday',
                'start_time' => '07:30',
                'end_time' => '12:30',
                'room' => 'B6'
            ],
            
            // Jeudi
            [
                'title' => 'SIC',
                'professor_id' => $profIlboudo->id,
                'day' => 'Thursday',
                'start_time' => '07:30',
                'end_time' => '12:30',
                'room' => 'B6'
            ],
            
            // Vendredi
            [
                'title' => 'Programmation Web dynamique',
                'professor_id' => $profGuinko->id,
                'day' => 'Friday',
                'start_time' => '07:30',
                'end_time' => '12:30',
                'room' => 'B6'
            ],
            [
                'title' => 'SIC',
                'professor_id' => $profIlboudo->id,
                'day' => 'Friday',
                'start_time' => '14:00',
                'end_time' => '18:00',
                'room' => 'B6'
            ]
        ];

        // Insérer tous les cours
        foreach ($schedules as $schedule) {
            Schedule::create(array_merge($schedule, [
                'class_id' => $class->id
            ]));
        }
    }
}
