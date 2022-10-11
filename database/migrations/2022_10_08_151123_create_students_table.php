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
            $table->UnsignedBigInteger('id_school_year');
            $table->UnsignedBigInteger('id_professional_focus');
            $table->string('name', 50);
            $table->integer('age');
            $table->double('first_score', 3, 1);
            $table->double('second_score', 3, 1);
            $table->timestamps();

            //Constraints/ foreign Keys
            $table->foreign('id_school_year')->references('id')->on('school_years');
            $table->foreign('id_professional_focus')->references('id')->on('professional_focus');
            
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
            $table->dropForeign('students_id_professional_focus_foreign');
            $table->dropForeign('students_id_school_year_foreign');
            $table->dropColumn('id_professional_focus');
            $table->dropColumn('id_school_year');
        });

        Schema::dropIfExists('students');
    }
}
