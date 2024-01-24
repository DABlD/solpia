<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSeaServicesAddShipManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sea_services', function (Blueprint $table) {
            $table->string('ship_manager')->nullable()->after('principal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sea_services', function (Blueprint $table) {
            $table->dropColumn('ship_manager');
        });
    }
}
