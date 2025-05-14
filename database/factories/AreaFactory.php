<?php

namespace Database\Factories;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Area>
 */
class AreaFactory extends Factory
{ protected $model = Area::class;

    public function definition()
    {
        return [
            'nombreArea' => $this->faker->words(2, true),
            'estado'     => $this->faker->boolean(80), // 80% activas
        ];
    }
}
