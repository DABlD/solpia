<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVesselsAddShipManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vessels', function (Blueprint $table) {
            $table->string('ship_manager')->nullable()->after('manning_agent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vessels', function (Blueprint $table) {
            $table->dropColumn('ship_manager');
        });
    }
}
