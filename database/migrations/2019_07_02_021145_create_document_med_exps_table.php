<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentMedExpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_med_exps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('applicant_id');

            $table->string('type')->nullable();
            $table->boolean('had')->nullable();
            $table->boolean('vaccine')->nullable();

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
        Schema::dropIfExists('document_med_exps');
    }
}
