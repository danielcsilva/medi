<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSuggestionToAccessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accessions', function (Blueprint $table) {
            
            $table->unsignedBigInteger('suggestion_id')->nullable();
            $table->foreign('suggestion_id')->references('id')->on('suggestions');

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
           
            $table->dropForeign(['suggestion_id']);
            $table->dropColumn('suggestion_id');

        });
    }
}
