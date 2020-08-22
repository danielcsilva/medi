<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessionContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accession_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->dateTime('contacted_date');
            $table->string('contacted_comments');
            
            $table->unsignedBigInteger('inconsistency_id')->nullable();
            $table->foreign('inconsistency_id')->references('id')->on('inconsistencies');

            $table->unsignedBigInteger('accession_id')->nullable();
            $table->foreign('accession_id')->references('id')->on('accessions');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('accession_contacts');
    }
}
