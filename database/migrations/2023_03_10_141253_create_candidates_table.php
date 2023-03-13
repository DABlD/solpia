<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedSmallInteger("applicant_id")->nullable();
            $table->unsignedSmallInteger("requirement_id");
            $table->unsignedSmallInteger("prospect_id");
            $table->unsignedSmallInteger("vessel_id");

            $table->boolean('initial_interview')->default(0);
            $table->boolean('written_assessment')->default(0);
            $table->boolean('technical_interview')->default(0);
            $table->boolean('principals_approval')->default(0);
            $table->boolean('medical')->default(0);
            $table->boolean('on_board')->default(0);

            $table->string('remarks')->nullable();
            $table->string('status')->default('PENDING');
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
        Schema::dropIfExists('candidates');
    }
}
