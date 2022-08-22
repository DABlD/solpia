<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedSmallInteger("vessel_id");
            $table->string("rank");
            $table->string("joining_date")->nullable();
            $table->string("joining_port")->nullable();
            $table->boolean("usv");
            $table->float("salary", 8, 2)->nullable();
            $table->string("remarks")->nullable();
            $table->unsignedTinyInteger("max_age");
            $table->enum("status", ["AVAILABLE", "CANCELLED", "ON HOLD"])->default("AVAILABLE");
            $table->string("fleet")->nullable();

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
        Schema::dropIfExists('requirements');
    }
}
