<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsLikesDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients_likes_doctors', function (Blueprint $table) {
            $table->integer('doctor_id')->unsigned();
            $table->bigInteger('patient_id')->unsigned();


            $table->foreign('doctor_id')
                ->references('id')
                ->on('doctors');

            $table->foreign('patient_id')
                ->references('id')
                ->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients_likes_doctors');
    }
}
