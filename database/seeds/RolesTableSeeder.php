<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::create(['name' => 'Diretoria']);
        Role::create(['name' => 'Operacional']);
        Role::create(['name' => 'Médico']);
        Role::create(['name' => 'Coordenação']);
        Role::create(['name' => 'Supervisão']);
        Role::create(['name' => 'Gerência']);
        Role::create(['name' => 'Cliente']);

        Role::create(['name' => 'SuperAdmin']);

    }
}
