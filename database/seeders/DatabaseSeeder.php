<?php

use Illuminate\Database\Seeder;
use Database\Seeders\RolesSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(RolesSeeder::class);
        // Vous pouvez ajouter d'autres séeders ici si nécessaire.
    }
}
