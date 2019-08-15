<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();

            $table->string('birth_place')->nullable();
            $table->string('religion')->nullable();

            $table->text('provincial_address')->nullable();
            $table->string('provincial_contact')->nullable();

            $table->integer('age');
            $table->double('height', 5, 2);
            $table->double('weight', 5, 2);
            $table->double('bmi', 5, 2);

            $table->string('blood_type', 5)->nullable();
            $table->enum('civil_status', ['Single', 'Married', 'Widowed', 'Divorced']);

            $table->string('tin')->nullable();
            $table->string('sss')->nullable();

            $table->double('waistline', 5, 2)->nullable();
            $table->double('shoe_size', 5, 2)->nullable();

            $table->enum('clothes_size', ['S', 'M', 'L', 'XL'])->nullable();
            $table->string('eye_color', 30)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicants');
    }
}
