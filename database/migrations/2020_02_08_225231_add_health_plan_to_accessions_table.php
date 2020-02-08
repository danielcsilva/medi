<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHealthPlanToAccessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accessions', function (Blueprint $table) {            

            $table->unsignedBigInteger('health_plan_id')->after('company_id')->nullable();
            $table->foreign('health_plan_id')->references('id')->on('health_plans');

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
            
            $table->dropForeign(['health_plan_id']);
            $table->dropColumn('health_plan_id');

        });
    }
}
