<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('school_year_id');
            $table->UnsignedBigInteger('professional_focus_id');
            $table->string('name', 50);
            $table->integer('age');
            $table->double('first_score', 3, 1);
            $table->double('second_score', 3, 1);
            $table->timestamps();

            //Constraints/ foreign Keys
            $table->foreign('school_year_id')->references('id')->on('school_years');
            $table->foreign('professional_focus_id')->references('id')->on('professional_focus');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign('students_professional_focus_id_foreign');
            $table->dropForeign('students_school_year_id_foreign');
            $table->dropColumn('professional_focus_id');
            $table->dropColumn('school_year_id');
            
        });

        Schema::dropIfExists('students');
    }
}
