<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentByItemToHealthDeclarationAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('health_declaration_answers', function (Blueprint $table) {
            
            $table->string('comment_number')->nullable();
            $table->string('comment_item')->nullable();
            $table->string('period_item')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('health_declaration_answers', function (Blueprint $table) {
            
            $table->dropColumn('comment_number');
            $table->dropColumn('comment_item');
            $table->dropColumn('period_item');

        });
    }
}
