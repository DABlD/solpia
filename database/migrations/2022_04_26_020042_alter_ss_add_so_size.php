<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSsAddSoSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vessels', function (Blueprint $table){
            $table->string('owner')->after('manning_agent')->nullable();
            $table->string('size')->after('engine')->nullable(); //EXPECTED LINEUP DATE
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vessels', function (Blueprint $table){
            $table->dropColumn('owner');
            $table->dropColumn('size');
        });
    }
}
