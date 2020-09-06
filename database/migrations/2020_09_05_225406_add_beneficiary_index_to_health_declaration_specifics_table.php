<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBeneficiaryIndexToHealthDeclarationSpecificsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('health_declaration_specifics', function (Blueprint $table) {
            $table->integer('beneficiary_index')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('health_declaration_specifics', function (Blueprint $table) {
            $table->dropColumn('beneficiary_index');
        });
    }
}
