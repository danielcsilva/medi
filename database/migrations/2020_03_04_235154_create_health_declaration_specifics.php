<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthDeclarationSpecifics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_declaration_specifics', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('comment_number')->nullable();
            $table->string('comment_item')->nullable();
            $table->string('period_item')->nullable();

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_declaration_specifics');
    }
}
