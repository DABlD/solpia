<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDobOnLineUpContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('line_up_contracts', function (Blueprint $table) {
            $table->unsignedTinyInteger('days')->default('0')->after('months');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('line_up_contracts', function (Blueprint $table) {
            $table->unsignedTinyInteger('days');
        });
    }
}
