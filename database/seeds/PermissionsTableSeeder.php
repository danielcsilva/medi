<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'Visualizar Processos']);
        Permission::create(['name' => 'Editar Processos']);

        Permission::create(['name' => 'Visualizar Entrevistas']);
        Permission::create(['name' => 'Editar Entrevistas']);

        Permission::create(['name' => 'Avaliar Processos Clinicamente']);
        Permission::create(['name' => 'Visualizar Indicadores e Relatórios']);

        Permission::create(['name' => 'Visualizar Usuários']);
        Permission::create(['name' => 'Editar Grupo de Usuários']);
        Permission::create(['name' => 'Editar Usuários']);


    }
}
