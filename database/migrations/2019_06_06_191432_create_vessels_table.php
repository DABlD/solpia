<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVesselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vessels', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('principal_id')->unsigned()->nullable();
            $table->string('manning_agent', 100)->default('Solpia');
            $table->string('name', 100)->nullable();
            $table->string('flag', 100)->nullable();
            $table->string('type', 100)->nullable();
            $table->string('year_build', 4)->nullable();
            $table->string('builder', 100)->nullable();
            $table->string('engine', 100)->nullable();
            $table->string('gross_tonnage', 100)->nullable();
            $table->string('BHP', 100)->nullable();
            $table->string('trade', 100)->nullable();
            $table->string('ecdis', 100)->nullable();
            $table->string('status', 100)->nullable();

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
        Schema::dropIfExists('vessels');
    }
}
