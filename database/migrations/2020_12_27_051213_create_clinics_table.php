<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->increments('id');

            /**
             * Short name of clinic.
             */
            $table->string('name', 64);
            $table->string('description', 512)->nullable();
            $table->string('address', 128)->nullable();
            $table->string('working_hours', 128)->nullable();
            $table->string('2gis_link', 256)->nullable();

            /**
             * Link to get directions to the clinic.
             */
            $table->string('2gis_route', 256)->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinics');
    }
}
