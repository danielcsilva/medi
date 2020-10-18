<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCidsMedicalAnalysisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cids_medical_analysis', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('medical_analysis_id');
            $table->unsignedBigInteger('cid_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cids_medical_analysis');
    }
}
