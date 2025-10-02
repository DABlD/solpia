<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('rank');
            $table->string('name');
            $table->string('assigned_vessel')->nullable();
            $table->string('person_to_visit');
            $table->string('purpose_of_visit');
            $table->string('availability');
            $table->string('status')->default('Waiting');
            $table->boolean('read')->default(0);
            $table->text('remarks')->nullable();

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
        Schema::dropIfExists('appointments');
    }
}