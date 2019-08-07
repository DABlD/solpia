<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->string('suffix')->nullable();
            $table->string('username')->nullable();
            $table->string('avatar')->default('images/default_avatar.jpg');
            $table->enum('role', ['Admin', 'Encoder', 'Applicant', 'Principal'])->nullable();
            
            $table->string('email')->nullable();
            // $table->string('email')->unique();
            $table->date('birthday');
            $table->string('gender');
            $table->text('address');
            $table->string('contact')->nullable();

            $table->boolean('applicant')->default(1);

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
