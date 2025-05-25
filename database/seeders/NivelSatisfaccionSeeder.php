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
                'emojiSatisfaccion' => '😡'
            ],
            [
                'codigoNivelSatisfaccion' => 2, 
                'nombreNivelSatisfaccion' => 'Insatisfecho',
                'emojiSatisfaccion' => '😔'],
            [
                'codigoNivelSatisfaccion' => 3,
                'nombreNivelSatisfaccion' => 'Neutral',
                'emojiSatisfaccion' => '😐'
            ],
            [
                'codigoNivelSatisfaccion' => 4,
                'nombreNivelSatisfaccion' => 'Satisfecho',
                'emojiSatisfaccion' => '😊'
            ],
            [
                'codigoNivelSatisfaccion' => 5,
                'nombreNivelSatisfaccion' => 'Muy satisfecho',
                'emojiSatisfaccion' => '😁'
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
