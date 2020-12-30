<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_phones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone', 14);
            $table->integer('doctor_id')->unsigned();

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
        Schema::dropIfExists('doctor_phones');
    }
}
