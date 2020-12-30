<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_phones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone', 14);
            $table->integer('clinic_id')->unsigned();


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
        Schema::dropIfExists('clinic_phones');
    }
}
