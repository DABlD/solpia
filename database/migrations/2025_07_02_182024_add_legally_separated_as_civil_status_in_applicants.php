<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLegallySeparatedAsCivilStatusInApplicants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicants', function (Blueprint $table){
            DB::statement("ALTER TABLE applicants CHANGE COLUMN civil_status civil_status ENUM(
                'Single', 'Married', 'Widowed', 'Divorced', 'Legally Separated'
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
        Schema::table('applicants', function (Blueprint $table) {
            //
        });
    }
}
