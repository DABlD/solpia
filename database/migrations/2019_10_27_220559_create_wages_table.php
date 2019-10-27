<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rank_id')->unsigned()->nullable();

            $table->integer('vessel_id')->unsigned()->nullable();
            $table->integer('principal_id')->unsigned()->nullable();

            $table->string('currency', 30)->nullable();

            $table->string('basic', 10)->nullable()->default(0);
            $table->string('leave_pay', 10)->nullable()->default(0);
            $table->string('fot', 10)->nullable()->default(0);
            $table->string('ot', 10)->nullable()->default(0);
            $table->string('sub_allow', 10)->nullable()->default(0);
            $table->string('retire_allow', 10)->nullable()->default(0);
            $table->string('sup_allow', 10)->nullable()->default(0);

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
        Schema::dropIfExists('wages');
    }
}
