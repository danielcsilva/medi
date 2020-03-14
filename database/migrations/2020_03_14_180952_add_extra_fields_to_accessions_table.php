<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToAccessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accessions', function (Blueprint $table) {
            
            $table->string('acomodation')->nullable();
            $table->string('plan_value')->nullable();
            $table->date('subscription_date')->nullable();
            $table->date('health_declaration_expires')->nullable();
            $table->date('registered_date')->nullable();
            $table->string('registered_by')->nullable();
            $table->boolean('to_contact')->default(0);
            $table->boolean('contacted')->default(0);
            $table->date('contacted_date')->nullable();
            $table->string('contacted_comments')->nullable();
            $table->string('interviewed_by')->nullable();
            $table->text('interview_comments')->nullable();
            $table->date('interview_date')->nullable();
            $table->string('interviewed_name')->nullable();
            $table->boolean('interview_validated')->default(0);
            $table->string('after_sales_comments')->nullable();
            $table->boolean('after_sales')->default(0);
            $table->boolean('analysis_status')->default(0);

             
            $table->unsignedBigInteger('process_status_id')->nullable();
            $table->foreign('process_status_id')->references('id')->on('process_status');

            $table->unsignedBigInteger('inconsistencies_id')->nullable();
            $table->foreign('inconsistencies_id')->references('id')->on('inconsistencies');

            $table->unsignedBigInteger('process_type_id')->nullable();
            $table->foreign('process_type_id')->references('id')->on('process_types');

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
            
            $table->dropColumn('acomodation');
            $table->dropColumn('plan_value');
            $table->dropColumn('subscription_date');
            $table->dropColumn('health_declaration_expires');
            $table->dropColumn('registered_date');
            $table->dropColumn('registered_by');
            $table->dropColumn('to_contact');
            $table->dropColumn('contacted');
            $table->dropColumn('contacted_date');
            $table->dropColumn('contacted_comments');
            $table->dropColumn('interviewed_by');
            $table->dropColumn('interview_comments');
            $table->dropColumn('interview_date');
            $table->dropColumn('interviewed_name');
            $table->dropColumn('interview_validated');
            $table->dropColumn('after_sales_comments');
            $table->dropColumn('after_sales');
            $table->dropColumn('analysis_status');

            $table->dropForeign(['process_status_id']);
            $table->dropColumn('process_status_id');

            $table->dropForeign(['inconsistencies_id']);
            $table->dropColumn('inconsistencies_id');

            $table->dropForeign(['inconsistencies_id']);
            $table->dropColumn('inconsistencies_id');

            $table->dropForeign(['process_type_id']);
            $table->dropColumn('process_type_id');
        });
    }
}
