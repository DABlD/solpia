<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentMedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_meds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('applicant_id');

            $table->string('type')->nullable();
            $table->string('with_mv')->nullable();
            $table->year('year')->nullable();
            $table->string('case_remarks')->nullable();
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
        Schema::dropIfExists('document_meds');
    }
}
