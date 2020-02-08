<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('proposal_number');

            $table->unsignedBigInteger('beneficiary_id')->nullable();
            $table->foreign('beneficiary_id')->references('id')->on('beneficiaries');

            $table->unsignedBigInteger('financier_id')->nullable();
            $table->foreign('financier_id')->references('id')->on('beneficiaries');

            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');            

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
        Schema::dropIfExists('accessions');
    }
}
