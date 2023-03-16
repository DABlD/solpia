<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProspectsAddHiredStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prospects', function (Blueprint $table){
            DB::statement("ALTER TABLE prospects CHANGE COLUMN status status ENUM(
                'AVAILABLE',
                'ENDORSED',
                'ON PROCESS',
                'HIRED'
            ) DEFAULT 'AVAILABLE' NULL");
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
