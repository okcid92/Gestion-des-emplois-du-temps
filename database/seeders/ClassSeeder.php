<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        ClassModel::create([
            'name' => 'LICENCE 1',
            'description' => 'Première année de licence en informatique'
        ]);

        ClassModel::create([
            'name' => 'LICENCE 2',
            'description' => 'Deuxième année de licence en informatique'
        ]);

        ClassModel::create([
            'name' => 'LICENCE 3',
            'description' => 'Troisième année de licence en informatique'
        ]);

    }
}
