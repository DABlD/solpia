<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentFlagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_flags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('applicant_id');
            
            $table->string('type');
            $table->string('rank')->nullable();
            $table->string('country');
            $table->string('number');
            // $table->string('booklet_no');
            // $table->string('license_no');
            // $table->string('goc');
            // $table->string('sso');
            // $table->string('sdsd');
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
        Schema::dropIfExists('document_flags');
    }
}
