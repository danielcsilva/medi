<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInconsistencyFieldToInconsistentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inconsistents', function (Blueprint $table) {
            $table->unsignedBigInteger('inconsistency_id')->nullable();
            $table->foreign('inconsistency_id')->references('id')->on('inconsistencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inconsistents', function (Blueprint $table) {
            $table->dropForeign(['inconsistency_id']);
            $table->dropColumn('inconsistency_id');
        });
    }
}
