<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProcessedApplicants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('processed_applicants', function (Blueprint $table){
            $table->string('principal_id')->nullable()->change(); 
            $table->string('vessel_id')->nullable()->change(); 
            $table->string('rank_id')->nullable()->change(); 
            $table->text('remarks')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('processed_applicants', function (Blueprint $table) {
            $table->string('principal_id')->nullable(false)->change();
            $table->string('vessel_id')->nullable(false)->change();
            $table->string('rank_id')->nullable(false)->change();

            $table->dropColumn('remarks');
        });
    }
}
