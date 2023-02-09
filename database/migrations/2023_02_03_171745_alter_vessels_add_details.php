<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVesselsAddDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vessels', function (Blueprint $table){
            $table->string('former_agency', 50)->after('particulars')->nullable();
            $table->string('former_principal', 50)->after('particulars')->nullable();
            $table->text('registered_shipowner_address')->after('particulars')->nullable();
            $table->string('registered_shipowner', 50)->after('particulars')->nullable();
            $table->text('mlc_shipowner_address')->after('particulars')->nullable();
            $table->string('mlc_shipowner', 50)->after('particulars')->nullable();

            // FOR POEA
            $table->unsignedInteger('work_hours')->after('former_agency')->nullable();
            $table->float("ot_per_hour", 5, 2)->after('work_hours')->nullable();
            $table->unsignedInteger('ot_hours')->after('ot_per_hour')->nullable();
            $table->string('cba_affiliation', 100)->after('ot_hours')->nullable();
            $table->string('classification', 20)->after('cba_affiliation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vessels', function (Blueprint $table){
            $table->dropColumn('former_agency');
            $table->dropColumn('former_principal');
            $table->dropColumn('mlc_shipowner');
            $table->dropColumn('mlc_shipowner_address');
            $table->dropColumn('registered_shipowner');
            $table->dropColumn('registered_shipowner_address');

            // FOR POEA
            $table->dropColumn('work_hours');
            $table->dropColumn('ot_per_hour');
            $table->dropColumn('ot_hours');
            $table->dropColumn('cba_affiliation');
            $table->dropColumn('classification');
        });
    }
}