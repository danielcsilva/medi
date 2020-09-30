<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeContactCommentsFieldToAccessionInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accession_interviews', function (Blueprint $table) {
            $table->text('interview_comments')->change();
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
            $table->string('interview_comments');
        });
    }
}
