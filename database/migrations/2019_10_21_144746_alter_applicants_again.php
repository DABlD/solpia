<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterApplicantsAgain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::table('applicants', function (Blueprint $table){
            $table->integer('age')->nullable()->change();

            DB::statement("ALTER TABLE applicants CHANGE COLUMN height height double(5, 2) NULL");
            DB::statement("ALTER TABLE applicants CHANGE COLUMN weight weight double(5, 2) NULL");
            DB::statement("ALTER TABLE applicants CHANGE COLUMN bmi bmi double(5, 2) NULL");

            DB::statement("ALTER TABLE applicants CHANGE COLUMN civil_status civil_status ENUM(
                'Single',
                'Married',
                'Widowed',
                'Divorced'
            ) NULL");

            DB::connection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->integer('age')->change();
        
        DB::statement("ALTER TABLE applicants CHANGE COLUMN height height double(5, 2)");
        DB::statement("ALTER TABLE applicants CHANGE COLUMN weight weight double(5, 2)");
        DB::statement("ALTER TABLE applicants CHANGE COLUMN bmi bmi double(5, 2)");
    }
}
