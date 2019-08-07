<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentLCsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_l_cs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('applicant_id');
            
            $table->string('type')->nullable();
            $table->string('rank')->nullable();
            $table->string('issuer')->nullable();
            $table->string('regulation')->nullable();
            $table->string('no')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_l_cs');
    }
}
