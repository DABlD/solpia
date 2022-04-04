<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wages', function (Blueprint $table) {
            $table->dropColumn('currency');
            
            $table->json('sr_pay')->after('sup_allow');
            $table->string('tanker_allow', 10)->nullable()->default(0)->after('sup_allow');
            $table->string('owner_allow', 10)->nullable()->default(0)->after('sup_allow');
            $table->string('voyage_allow', 10)->nullable()->default(0)->after('sup_allow');
            $table->string('other_allow', 10)->nullable()->default(0)->after('sup_allow');
            $table->string('engine_allow', 10)->nullable()->default(0)->after('sup_allow');
            $table->string('aca', 10)->nullable()->default(0)->after('sup_allow');
            $table->string('total', 10)->nullable()->default(0)->after('sup_allow');
            $table->string('imo', 10)->nullable()->default(0)->after('sup_allow');
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
            $table->dropColumn('sr_pay');
            $table->dropColumn('tanker_allow');
            $table->dropColumn('owner_allow');
            $table->dropColumn('voyage_allow');
            $table->dropColumn('other_allow');
            $table->dropColumn('engine_allow');
            $table->dropColumn('aca');
            $table->dropColumn('total');
            $table->dropColumn('imo');
            
            $table->string('currency', 30)->nullable()->after('principal_id');
        });

    }
}
