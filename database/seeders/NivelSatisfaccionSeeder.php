<?php

namespace Database\Seeders;

use App\Models\nivel_satisfaccion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NivelSatisfaccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveles = [
            [
                'codigoNivelSatisfaccion' => 1,
                'nombreNivelSatisfaccion' => 'Muy insatisfecho',
                'emojiSatisfaccion' => '😡',
                'porcentaje_nivel_satisfaccion' => '20',
            ],
            [
                'codigoNivelSatisfaccion' => 2, 
                'nombreNivelSatisfaccion' => 'Insatisfecho',
                'emojiSatisfaccion' => '😔',
                'porcentaje_nivel_satisfaccion' => '40',
            ],
            [
                'codigoNivelSatisfaccion' => 3,
                'nombreNivelSatisfaccion' => 'Neutral',
                'emojiSatisfaccion' => '😐',
                'porcentaje_nivel_satisfaccion' => '60',
            ],
            [
                'codigoNivelSatisfaccion' => 4,
                'nombreNivelSatisfaccion' => 'Satisfecho',
                'emojiSatisfaccion' => '😊',
                'porcentaje_nivel_satisfaccion' => '80',
            ],
            [
                'codigoNivelSatisfaccion' => 5,
                'nombreNivelSatisfaccion' => 'Muy satisfecho',
                'emojiSatisfaccion' => '😁',
                'porcentaje_nivel_satisfaccion' => '100',
            ],
        ];

        foreach ($niveles as $nivel) {
            nivel_satisfaccion::updateOrCreate(
                ['codigoNivelSatisfaccion' => $nivel['codigoNivelSatisfaccion']],
                array_merge($nivel, ['estadoNivelSatisfaccion' => 1])
            );
        }
    }
}
