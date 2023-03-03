<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMedCertAddIssuer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_med_certs', function (Blueprint $table) {
            $table->string('issuer')->nullable()->after('clinic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_med_certs', function (Blueprint $table) {
            $table->dropColumn('issuer');
        });
    }
}
