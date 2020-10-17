<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropWrongKeyToAccessionMedicalAnalysisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accession_medical_analysis', function (Blueprint $table) {
            $table->dropForeign(['acession_id']);
            $table->dropColumn('acession_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accession_medical_analysis', function (Blueprint $table) {
            $table->unsignedBigInteger('acession_id')->nullable();
            $table->foreign('acession_id')->references('id')->on('accessions');
        });
    }
}
