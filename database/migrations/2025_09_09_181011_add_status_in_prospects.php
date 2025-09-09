<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusInProspects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prospects', function (Blueprint $table) {
            Schema::table('prospects', function (Blueprint $table){
                DB::statement("ALTER TABLE prospects CHANGE COLUMN status status ENUM(
                    'AVAILABLE',
                    'ENDORSED',
                    'ON PROCESS',
                    'HIRED',
                    'PASSED',
                    'FAILED',
                    'BACK OUT'

                ) DEFAULT 'AVAILABLE' NULL");
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prospects', function (Blueprint $table) {
            //
        });
    }
}
