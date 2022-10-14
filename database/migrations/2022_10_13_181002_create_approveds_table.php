<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approved', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('situation_id');
            $table->string('name', 50);
            $table->string('professional_area', 20);
            $table->string('school_year');
        
            $table->timestamps();

            //foreign keys
            $table->foreign('situation_id')->references('id')->on('situations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('approved', function (Blueprint $table) {
            $table->dropForeign('approved_situation_id_foreign');
            $table->dropColumn('situation_id');
        });

        Schema::dropIfExists('approveds');
    }
}
