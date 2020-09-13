<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateCidInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cids_interviews', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('cid_id')->nullable();
            $table->foreign('cid_id')->references('id')->on('accession_cids');

            $table->unsignedBigInteger('interview_id')->nullable();
            $table->foreign('interview_id')->references('id')->on('accession_interviews');

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
        Schema::dropIfExists('cids_interviews');
        
    }
}
