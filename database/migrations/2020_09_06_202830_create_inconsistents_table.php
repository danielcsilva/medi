<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInconsistentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inconsistents', function (Blueprint $table) {

            $table->unsignedBigInteger('inconsistencies_id')->nullable();
            $table->foreign('inconsistencies_id')->references('id')->on('inconsistencies');

            $table->bigInteger('inconsistent_id');
            $table->string('inconsistent_type');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inconsistents');
    }
}
