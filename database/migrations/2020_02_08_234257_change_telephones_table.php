<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTelephonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telephones', function (Blueprint $table) {            

            $table->unsignedBigInteger('accession_id')->after('telephone')->nullable();
            $table->foreign('accession_id')->references('id')->on('accessions');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telephones', function (Blueprint $table) {            

            $table->dropForeign(['accession_id']);
            $table->dropColumn('accession_id');

        });
    }
}
