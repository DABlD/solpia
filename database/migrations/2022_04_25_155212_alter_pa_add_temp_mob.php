<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPaAddTempMob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('processed_applicants', function (Blueprint $table){
            $table->integer('mob')->after('status')->nullable();
            $table->string('eld')->after('mob')->nullable(); //EXPECTED LINEUP DATE
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
            $table->dropColumn('mob');
            $table->dropColumn('eld');
        });
    }
}
