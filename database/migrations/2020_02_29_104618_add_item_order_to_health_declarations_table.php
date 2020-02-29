<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemOrderToHealthDeclarationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('health_declarations', function (Blueprint $table) {
            
            $table->integer('item_number')->after('comments')->nullable();
            $table->string('item_number_obs')->after('comments')->nullable();
            $table->string('comments')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('health_declarations', function (Blueprint $table) {
            
            $table->dropColumn('item_number');
            $table->dropColumn('item_number_obs');
            $table->string('comments');

        });
    }
}
