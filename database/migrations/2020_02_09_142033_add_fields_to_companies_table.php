<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            
            $table->string('cnpj', 14)->after('name')->nullable();
            $table->string('email')->afeter('name')->nullable();
            $table->string('telephone')->after('name')->nullable();            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            
            $table->dropColumn('cnpj');
            $table->dropColumn('email');
            $table->dropColumn('telephone');

        });
    }
}
