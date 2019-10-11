<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineUpContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_up_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('applicant_id');
            $table->integer('principal_id');
            $table->integer('vessel_id');
            $table->integer('rank_id');
            $table->string('joining_port');
            $table->date('joining_date');
            $table->integer('months');
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
        Schema::dropIfExists('line_up_contracts');
    }
}
