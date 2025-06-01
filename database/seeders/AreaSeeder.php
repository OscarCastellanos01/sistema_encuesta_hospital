<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Area::insert([
            ['nombreArea' => 'Recepción', 'estado' => 1],
            ['nombreArea' => 'Urgencias',  'estado' => 1],
            ['nombreArea' => 'Rayos X',   'estado' => 1],
            ['nombreArea' => 'Laboratorio','estado' => 1],
            ['nombreArea' => 'Farmacia',   'estado' => 1],
        ]);
    }
}
