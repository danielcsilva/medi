<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeActionFieldToDelegationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delegations', function (Blueprint $table) {
            $table->string('action')->nullable()->change();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delegations', function (Blueprint $table) {
            $table->set('action', ['Contato', 'Entrevista', 'Revisão', 'Análise Médica'])->nullable();
            
        });
    }
}
