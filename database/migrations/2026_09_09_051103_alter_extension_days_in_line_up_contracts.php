<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterExtensionDaysInLineUpContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('line_up_contracts', function (Blueprint $table) {
            Schema::table('line_up_contracts', function (Blueprint $table) {
                $table->text('extensions_days')->nullable()->change();
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
        Schema::table('line_up_contracts', function (Blueprint $table) {
            Schema::table('line_up_contracts', function (Blueprint $table) {
                $table->tinyInteger('extensions_days')->nullable()->change();
            });
        });
    }
}
