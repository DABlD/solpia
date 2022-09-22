<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSeaServicesAddDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sea_services', function (Blueprint $table) {
            $table->string('owner')->nullable()->after('principal');
            $table->string('size')->nullable()->after('gross_tonnage');
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
            $table->dropColumn('owner');
            $table->dropColumn('size');
        });
    }
}
