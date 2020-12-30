<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateDoctorReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('patient_id')->unsigned();
            $table->integer('doctor_id')->unsigned();
            $table->string('message', 2048)->nullable();

            /**
             * From 1 to 5
             */
            $table->tinyInteger('mark');
            $table->timestamp('created_at');


            $table->foreign('patient_id')
                ->references('id')
                ->on('patients');

            $table->foreign('doctor_id')
                ->references('id')
                ->on('doctors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_reviews');
    }
}
