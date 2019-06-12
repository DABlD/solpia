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

            $table->integer('principal_id')->unsigned();
            $table->string('manning_agent', 100)->default('Solpia');
            $table->string('name', 100);
            $table->string('flag', 100);
            $table->string('type', 100);
            $table->string('year_build', 4);
            $table->string('builder', 100);
            $table->string('engine', 100);
            $table->string('gross_tonnage', 100);
            $table->string('BHP', 100);
            $table->string('trade', 100);
            $table->string('ecdis', 100);
            $table->string('status', 100);

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
