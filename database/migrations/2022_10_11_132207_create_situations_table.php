<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSituationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('situations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->double('total_score', 4, 1);
            $table->char('situation', 1);
            $table->timestamps();

            //foreign keys
            $table->foreign('student_id')->references('id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('situations', function (Blueprint $table) {
            $table->dropForeign('situations_student_id_foreign');
            $table->dropColumn('student_id');
        });

        Schema::dropIfExists('situations');
    }
}
