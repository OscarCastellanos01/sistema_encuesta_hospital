<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['nombre' => 'Administrador', 'estado' => 0],
            ['nombre' => 'Facilitador', 'estado' => 0],
            ['nombre' => 'Super Admin', 'estado' => 1],
        ];

        foreach ($roles as $rol) {
            Role::firstOrCreate($rol);
        }
    }
}
