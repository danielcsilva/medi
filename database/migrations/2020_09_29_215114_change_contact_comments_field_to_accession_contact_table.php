<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeContactCommentsFieldToAccessionContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accession_contacts', function (Blueprint $table) {
            $table->text('contacted_comments')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accession_contacts', function (Blueprint $table) {
            $table->string('contacted_comments');
        });
    }
}
