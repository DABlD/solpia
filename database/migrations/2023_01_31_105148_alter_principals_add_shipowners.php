<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPrincipalsAddShipowners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('principals', function (Blueprint $table){
            $table->string('full_name', 50)->after('name')->nullable();
            $table->text('address')->after('full_name')->nullable();
            $table->string('mlc_shipowner', 50)->after('address')->nullable();
            $table->text('mlc_shipowner_address')->after('mlc_shipowner')->nullable();
            $table->string('registered_shipowner', 50)->after('mlc_shipowner_address')->nullable();
            $table->text('registered_shipowner_address')->after('registered_shipowner')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('principals', function (Blueprint $table){
            $table->dropColumn('full_name');
            $table->dropColumn('address');
            $table->dropColumn('mlc_shipowner');
            $table->dropColumn('mlc_shipowner_address');
            $table->dropColumn('registered_shipowner');
            $table->dropColumn('registered_shipowner_address');
        });
    }
}
