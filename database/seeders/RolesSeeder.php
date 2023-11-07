<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Créez vos rôles
        Role::create(['name' => 'Utilisateur']);
        Role::create(['name' => 'Administrateur']);
        Role::create(['name' => 'Modérateur']);
        Role::create(['name' => 'Éditeur']);
    }
}
