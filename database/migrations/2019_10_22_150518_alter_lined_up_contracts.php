<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLinedUpContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('line_up_contracts', function (Blueprint $table) {
            $table->string('disembarkation_port')->after('joining_date')->nullable();
            $table->date('disembarkation_date')->after('disembarkation_port')->nullable();
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
            $table->dropColumn('disembarkation_port');
            $table->dropColumn('disembarkation_date');
        });
    }
}
