<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('patient_id')->unsigned();
            $table->integer('clinic_id')->unsigned();
            $table->string('message', 2048)->nullable();

            /**
             * From 1 to 5
             */
            $table->tinyInteger('mark');
            $table->timestamp('created_at')->nullable()->default(
                DB::raw('CURRENT_TIMESTAMP()')
            );


            $table->foreign('patient_id')
                ->references('id')
                ->on('patients');

            $table->foreign('clinic_id')
                ->references('id')
                ->on('clinics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_reviews');
    }
}
