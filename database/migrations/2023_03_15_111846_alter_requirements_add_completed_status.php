<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRequirementsAddCompletedStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requirements', function (Blueprint $table){
            DB::statement("ALTER TABLE requirements CHANGE COLUMN status status ENUM(
                'AVAILABLE',
                'CANCELLED',
                'ON HOLD',
                'COMPLETED'
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
