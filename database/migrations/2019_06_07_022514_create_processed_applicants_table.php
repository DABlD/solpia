<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessedApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processed_applicants', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('applicant_id')->unsigned();
            $table->integer('principal_id')->unsigned();
            $table->integer('vessel_id')->unsigned();
            $table->integer('rank_id')->unsigned();
            $table->string('status');

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
        Schema::dropIfExists('processed_applicants');
    }
}
