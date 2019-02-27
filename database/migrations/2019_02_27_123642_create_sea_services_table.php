<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeaServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sea_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('applicant_id');
            
            $table->string('vessel_name', 100);
            $table->string('rank', 50);
            $table->string('vessel_type', 50)->nullable();
            $table->string('gross_tonnage', 100)->nullable();
            $table->string('engine_type', 100)->nullable();
            $table->string('bhp_kw', 100)->nullable();
            $table->string('flag', 50)->nullable();
            $table->string('trade', 50)->nullable();
            $table->double('previous_salary', 8,2)->nullable();
            $table->string('manning_agent', 100)->nullable();
            $table->string('principal', 100)->nullable();
            $table->string('crew_nationality', 50)->nullable();
            $table->date('sign_on');
            $table->date('sign_off');
            $table->integer('total_months');
            $table->text('remarks')->nullable();
            $table->string('charterer', 100)->nullable();
            $table->text('cargoes')->nullable();
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
        Schema::dropIfExists('sea_services');
    }
}
