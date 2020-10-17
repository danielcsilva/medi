<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessionMedicalAnalysisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accession_medical_analysis', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('acession_id')->nullable();
            $table->foreign('acession_id')->references('id')->on('accessions');

            $table->unsignedBigInteger('beneficiary_id')->nullable();
            $table->foreign('beneficiary_id')->references('id')->on('beneficiaries');

            $table->unsignedBigInteger('risk_grade_id')->nullable();
            $table->foreign('risk_grade_id')->references('id')->on('risk_grades');

            $table->unsignedBigInteger('suggestion_id')->nullable();
            $table->foreign('suggestion_id')->references('id')->on('suggestions');

            $table->text('justification')->nullable();

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
        Schema::dropIfExists('accession_medical_analysis');
    }
}
