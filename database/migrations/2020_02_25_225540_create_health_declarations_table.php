<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthDeclarationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_declarations', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('comment_number')->nullable();
            $table->string('comment_item')->nullable();
            $table->string('period_item')->nullable();
            $table->string('comments')->nullable();
            
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
        Schema::dropIfExists('health_declarations');
    }
}
