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
        //Processos
        Permission::create(['name' => 'Visualizar Processos']);
        Permission::create(['name' => 'Editar Processos']);

        //Contatos
        Permission::create(['name' => 'Visualizar Contatos']);
        Permission::create(['name' => 'Editar Contatos']);

        //Entrevistas
        Permission::create(['name' => 'Visualizar Entrevistas']);
        Permission::create(['name' => 'Editar Entrevistas']);

        //Avaliar processos
        Permission::create(['name' => 'Avaliar Processos Clinicamente']);
        Permission::create(['name' => 'Visualizar Indicadores e Relatórios']);

        //Delegar processos
        Permission::create(['name' => 'Delegar Processos']);

        //Fazer revisão de processos
        Permission::create(['name' => 'Revisar Processos']);

        //Editar processos após finalizados (edit fisnished process)
        Permission::create(['name' => 'Editar Processos Finalizados']);

        //Usuários
        Permission::create(['name' => 'Visualizar Usuários']);
        Permission::create(['name' => 'Editar Grupo de Usuários']);
        Permission::create(['name' => 'Editar Usuários']);
        

    }
}
