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
            $table->text('contact')->after('address')->nullable();
            $table->text('email')->after('contact')->nullable();
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
            $table->dropColumn('contact');
            $table->dropColumn('email');
        });
    }
}
