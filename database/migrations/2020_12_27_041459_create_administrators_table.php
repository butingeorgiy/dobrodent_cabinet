<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->increments('id');
            $table->string('login', 14);
            $table->string('password', 64);
            $table->string('name', 128);

            /**
             * Type of privileges that administrator has.
             *
             * Available values:
             *  1 – just administrator
             *  2 – owner of business
             *  3 – accountant
             *  4 – steward (a person responsible for supplies of equipment and etc.)
             */
            $table->tinyInteger('privileges_id')->unsigned();


            $table->foreign('privileges_id')
                ->references('id')
                ->on('privileges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrators');
    }
}
