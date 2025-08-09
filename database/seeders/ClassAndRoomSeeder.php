<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassModel;
use App\Models\Salle;

class ClassAndRoomSeeder extends Seeder
{
    public function run()
    {
        // Création des niveaux de licence
        $classes = [
            ['name' => 'Licence 1', 'description' => 'Première année de licence'],
            ['name' => 'Licence 2', 'description' => 'Deuxième année de licence'],
            ['name' => 'Licence 3', 'description' => 'Troisième année de licence'],
        ];

        foreach ($classes as $class) {
            ClassModel::create($class);
        }

        // Création des salles de cours
        $salles = [
            // Bloc A
            ['nom' => 'A1', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            ['nom' => 'A2', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            ['nom' => 'A3', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            ['nom' => 'A4', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            ['nom' => 'A5', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            ['nom' => 'A6', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            
            // Bloc B
            ['nom' => 'B1', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            ['nom' => 'B2', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            ['nom' => 'B3', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            ['nom' => 'B4', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            ['nom' => 'B5', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            ['nom' => 'B6', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            ['nom' => 'B7', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            
            // Bloc C
            ['nom' => 'C1', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            ['nom' => 'C2', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
            ['nom' => 'C3', 'type' => 'Salle de cours', 'capacite' => 50, 'disponible' => true],
        ];

        foreach ($salles as $salle) {
            Salle::create($salle);
        }
    }
}
