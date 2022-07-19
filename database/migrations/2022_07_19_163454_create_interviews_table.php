<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedMediumInteger('prospect_id');
            $table->unsignedMediumInteger('requirement_id');
            $table->enum("status", ["ENDORSED", "FOR INTERVIEW", "PASSED INTERVIEW", "FAILED INTERVIEW", "FOR APPROVAL", "FOR MEDICAL", "WITHDRAW"])->default("ENDORSED");
            $table->string("remark")->nullable();

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
        Schema::dropIfExists('interviews');
    }
}
