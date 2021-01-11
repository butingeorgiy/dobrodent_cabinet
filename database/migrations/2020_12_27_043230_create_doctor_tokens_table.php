<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');

            /**
             * Random string, 32 characters long.
             *
             * Available characters: [a-zA-Z].
             */
            $table->char('token', 32);
            $table->integer('doctor_id')->unsigned();
            $table->timestamp('created_at')->nullable()->default(
                DB::raw('CURRENT_TIMESTAMP()')
            );

            /**
             * Seconds after authorization that token is valid.
             *
             * Available values:
             *  28800 – non-saved authorization (8 hours)
             *  604800 – saved authorization (7 days)
             */
            $table->integer('time_valid')->default(28800);


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
        Schema::dropIfExists('doctor_tokens');
    }
}
