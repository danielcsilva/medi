<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToAccessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accessions', function (Blueprint $table) {
            $table->string('acomodation')->nullable();
            $table->string('plan_value')->nullable();
            $table->date('subscription_date')->nullable();
            $table->date('health_declaration_expires')->nullable();
            $table->date('registered_date')->nullable();
            $table->string('registered_by')->nullable();
            $table->boolean('to_contact')->default(0);
            $table->boolean('contacted')->default(0);
            $table->date('contacted_date')->nullable();
            $table->string('interviewed_by')->nullable();
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
            //
        });
    }
}
