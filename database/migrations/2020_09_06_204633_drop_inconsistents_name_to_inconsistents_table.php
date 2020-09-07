<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropInconsistentsNameToInconsistentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inconsistents', function (Blueprint $table) {
            $table->dropForeign(['inconsistencies_id']);
            $table->dropColumn('inconsistencies_id');
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
            $table->unsignedBigInteger('inconsistencies_id')->nullable();
            $table->foreign('inconsistencies_id')->references('id')->on('inconsistencies');
        });
    }
}
