<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeavePerMonthInWage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wages', function (Blueprint $table) {
            $table->smallInteger('leave_per_month')->after('ot_per_hour')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wages', function (Blueprint $table) {
            $table->dropColumn('leave_per_month');
        });
    }
}
