<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuestionIdToHealthDeclarationSpecificsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('health_declaration_specifics', function (Blueprint $table) {
            $table->unsignedBigInteger('question_id')->nullable();
            $table->foreign('question_id')->references('id')->on('health_questions');
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
            $table->dropForeign(['question_id']);
            $table->dropColumn('question_id');
        });
    }
}
