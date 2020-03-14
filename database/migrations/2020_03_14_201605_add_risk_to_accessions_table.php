<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRiskToAccessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accessions', function (Blueprint $table) {
            

            $table->unsignedBigInteger('risk_grade_id')->nullable();
            $table->foreign('risk_grade_id')->references('id')->on('risk_grades');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accessions', function (Blueprint $table) {
            
            $table->dropForeign(['risk_grade_id']);
            $table->dropColumn('risk_grade_id');


        });
    }
}
