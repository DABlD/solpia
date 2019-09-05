<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Alter2SeaService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sea_services', function (Blueprint $table){
            $table->string('gross_tonnage', 100)->nullable(false)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::table('sea_services', function (Blueprint $table){
            $table->string('gross_tonnage', 100)->nullable()->change();
        });
    }
}
