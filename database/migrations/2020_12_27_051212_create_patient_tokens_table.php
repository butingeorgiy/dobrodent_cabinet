<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');

            /**
             * Random string, 32 characters long.
             *
             * Available characters: [a-zA-Z].
             */
            $table->char('token', 32);
            $table->bigInteger('patient_id')->unsigned();
            $table->timestamp('created_at');

            /**
             * Seconds after authorization that token is valid.
             *
             * Available values:
             *  28800 – non-saved authorization (8 hours)
             *  604800 – saved authorization (7 days)
             */
            $table->integer('time_valid')->default(28800);


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
        Schema::dropIfExists('patient_tokens');
    }
}
