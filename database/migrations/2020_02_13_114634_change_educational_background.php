<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEducationalBackground extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educational_backgrounds', function (Blueprint $table){
            DB::statement("ALTER TABLE educational_backgrounds CHANGE COLUMN type type ENUM(
                'Elementary', 
                'High School', 
                'Vocational', 
                'Undergraduate',
                'College'
            ) NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
