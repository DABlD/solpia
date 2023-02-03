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
        });
    }
}