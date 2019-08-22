<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilyDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('applicant_id');

            $table->string('email')->nullable();
            $table->string('type')->nullable();
            $table->integer('age')->nullable();
            
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('lname')->nullable();
            $table->string('suffix')->nullable();

            $table->date('birthday')->nullable();
            $table->text('address')->nullable();
            $table->string('occupation')->nullable();

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
        Schema::dropIfExists('family_datas');
    }
}
