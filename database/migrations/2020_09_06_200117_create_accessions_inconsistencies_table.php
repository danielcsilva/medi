<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessionsInconsistenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessions_inconsistencies', function (Blueprint $table) {
            
            $table->unsignedBigInteger('inconsistency_id')->nullable();
            $table->foreign('inconsistency_id')->references('id')
                ->on('inconsistencies');

            $table->unsignedBigInteger('accession_id')->nullable();
            $table->foreign('accession_id')->references('id')
                ->on('accessions');
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accessions_inconsistencies');
    }
}
