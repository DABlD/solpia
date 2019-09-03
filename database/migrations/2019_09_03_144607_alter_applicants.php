<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterApplicants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicants', function (Blueprint $table){
            DB::statement("ALTER TABLE applicants CHANGE COLUMN clothes_size clothes_size ENUM(
                'S', 
                'M',
                'L',
                'XL',
                'XXL',
                'XXXL'
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
        Schema::table('applicants', function (Blueprint $table){
            DB::statement("ALTER TABLE applicants CHANGE COLUMN clothes_size clothes_size ENUM(
                'S', 
                'M',
                'L',
                'XL'
            ) NULL");
        });
    }
}
