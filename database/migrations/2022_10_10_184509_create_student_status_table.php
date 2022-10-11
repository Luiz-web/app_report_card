<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_student');
            $table->double('total_score', 4, 1);
            $table->char('situation', 1);
            $table->timestamps();

            //foreign keys
            $table->foreign('id_student')->references('id')->on('students');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_status', function (Blueprint $table) {
            $table->dropForeign('student_status_id_student_foreign');
            $table->dropColumn('id_student');
        });

        Schema::dropIfExists('student_status');
    }
}
