<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospects', function (Blueprint $table) {
            $table->increments('id');

            $table->string("name")->nullable();
            $table->date("birthday")->nullable();
            $table->unsignedTinyInteger("age")->nullable();
            $table->string("contact")->nullable();
            $table->string("email")->nullable();
            $table->string("usv")->nullable();
            $table->string("rank")->nullable();
            $table->unsignedTinyInteger("contracts")->nullable();
            $table->string("exp")->nullable();
            $table->string("availability")->nullable();
            $table->date("last_disembark")->nullable();
            $table->string("location")->nullable();
            $table->string("previous_salary")->nullable();
            $table->string("previous_agency")->nullable();
            $table->string("remarks")->nullable();
            $table->enum("status", ["AVAILABLE", "ENDORSED", "ON PROCESS"])->default("AVAILABLE");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prospects');
    }
}