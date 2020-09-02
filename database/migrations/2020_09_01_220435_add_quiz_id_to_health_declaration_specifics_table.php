<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuizIdToHealthDeclarationSpecificsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('health_declaration_specifics', function (Blueprint $table) {
            $table->unsignedBigInteger('quiz_id')->nullable();
            $table->foreign('quiz_id')->references('id')->on('quizzes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('health_declaration_specifics', function (Blueprint $table) {
            $table->dropForeign(['quiz_id']);
            $table->dropColumn('quiz_id');
        });
    }
}
