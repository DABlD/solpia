<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProAppAddSeniority extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('processed_applicants', function (Blueprint $table){
            $table->smallInteger('seniority')->nullable()->default(1)->after('rank_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::table('processed_applicants', function (Blueprint $table){
            $table->dropColumn('seniority');
        });
    }
}
