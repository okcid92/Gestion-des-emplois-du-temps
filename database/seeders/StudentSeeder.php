<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ClassModel;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run()
    {
        // Récupérer la classe
        $class = ClassModel::where('name', 'LICENCE 2')->first();

        // Créer un étudiant test
        User::create([
            'name' => 'Étudiant',
            'prenom' => 'Test',
            'email' => 'etudiant@ibam.bf',
            'password' => bcrypt('password'),
            'role' => 'student',
            'class_id' => $class->id
        ]);
    }
}
