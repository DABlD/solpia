<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table){
            DB::statement("ALTER TABLE users CHANGE COLUMN role role ENUM(
                'Admin', 
                'Cadet',
                'Encoder',
                'Applicant',
                'Principal',
                'Crewing Manager',
                'Crewing Officer',
                'Processing'
            ) NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
