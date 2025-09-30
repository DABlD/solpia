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
            $table->string('lname');
            $table->string('fname');
            $table->string('assigned_vessel')->nullable();
            $table->date('sign_on')->nullable();
            $table->date('sign_off')->nullable();
            $table->string('contact')->nullable();
            $table->string('age')->nullable();
            $table->string('person_to_visit');
            $table->string('purpose_of_visit');
            $table->string('recommended_by')->nullable();
            $table->string('status')->default('Pending');
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