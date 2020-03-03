<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_declaration_answers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('question');
            $table->string('answer');

            $table->unsignedBigInteger('beneficiary_id')->nullable();
            $table->foreign('beneficiary_id')->references('id')->on('beneficiaries');

            $table->unsignedBigInteger('accession_id')->nullable();
            $table->foreign('accession_id')->references('id')->on('accessions');
              
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
        Schema::dropIfExists('health_answers');
    }
}