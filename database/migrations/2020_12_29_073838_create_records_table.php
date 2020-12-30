<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 128);
            $table->string('description', 2048);
            $table->bigInteger('illness_id')->unsigned();
            $table->integer('doctor_id')->unsigned();
            $table->tinyInteger('record_type_id')->unsigned();
            $table->timestamp('created_at');


            $table->foreign('illness_id')
                ->references('id')
                ->on('illnesses');

            $table->foreign('doctor_id')
                ->references('id')
                ->on('doctors');

            $table->foreign('record_type_id')
                ->references('id')
                ->on('record_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
