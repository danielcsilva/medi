<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropInconsistencyColumnToAccessionInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accession_interviews', function (Blueprint $table) {
            $table->dropForeign(['inconsistency_id']);
            $table->dropColumn('inconsistency_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accession_interviews', function (Blueprint $table) {
            $table->unsignedBigInteger('inconsistencies_id')->nullable();
            $table->foreign('inconsistencies_id')->references('id')->on('inconsistencies');
        });
    }
}
