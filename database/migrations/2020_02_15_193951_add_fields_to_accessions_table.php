<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAccessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accessions', function (Blueprint $table) {
            $table->date('received_at');
            $table->string('admin_partner')->nullable();
            $table->string('health_plan_partner')->nullable();
            $table->date('initial_validity')->nullable();
            $table->string('consult_partner')->nullable();
            $table->string('broker_partner')->nullable();

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
            $table->dropColumn('received_at');
            $table->dropColumn('admin_partner');
            $table->dropColumn('health_plan_partner');
            $table->dropColumn('initial_validity');
            $table->dropColumn('consult_partner');
            $table->dropColumn('broker_partner');

        });
    }
}
