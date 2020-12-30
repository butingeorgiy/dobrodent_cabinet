<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->bigIncrements('id');

            /**
             * Cause of visit that wrote by patient.
             */
            $table->string('cause', 1024)->nullable();

            /**
             * Result of visit that wrote by doctor after it.
             */
            $table->string('result', 2048);

            $table->bigInteger('patient_id')->unsigned();
            $table->bigInteger('illness_id')->unsigned();
            $table->integer('doctor_id')->unsigned();
            $table->integer('clinic_id')->unsigned();
            $table->timestamp('created_at');
            $table->timestamp('visit_time')->nullable();

            /**
             * Available values:
             *
             *  1 – created
             *  2 – confirmed (by doctor or administrators)
             *  3 – in the process (updated automatically)
             *  4 – deferred (visit is finished, but doctor fill it later)
             *  5 – finished
             *  6 – canceled
             */
            $table->tinyInteger('visit_status_id')->unsigned();


            $table->foreign('patient_id')
                ->references('id')
                ->on('patients');

            $table->foreign('illness_id')
                ->references('id')
                ->on('illnesses');

            $table->foreign('doctor_id')
                ->references('id')
                ->on('doctors');

            $table->foreign('clinic_id')
                ->references('id')
                ->on('clinics');

            $table->foreign('visit_status_id')
                ->references('id')
                ->on('visit_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
