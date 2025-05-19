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
            ['nombre' => 'admin', 'estado' => 0],
            ['nombre' => 'facilitador', 'estado' => 0],
            ['nombre' => 'superadmin', 'estado' => 1],
        ];

        foreach ($roles as $rol) {
            Role::firstOrCreate($rol);
        }
    }
}
