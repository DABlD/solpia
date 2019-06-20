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
            
            $table->string('type');
            $table->string('rank')->nullable();
            $table->string('issuer');
            $table->string('regulation')->nullable();
            $table->string('no');
            $table->date('issue_date');
            $table->date('expiry_date');
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
