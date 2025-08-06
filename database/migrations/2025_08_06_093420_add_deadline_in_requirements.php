<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeadlineInRequirements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requirements', function (Blueprint $table) {
            $table->string('deadline')->after('date_provided')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requirements', function (Blueprint $table) {
            $table->dropColumn('deadline');
        });
    }
}
