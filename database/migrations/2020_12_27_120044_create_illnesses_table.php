<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIllnessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('illnesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 128);
            $table->string('description', 1024);
            $table->bigInteger('patient_id')->unsigned();
            $table->tinyInteger('illness_status_id')->unsigned();
            $table->timestamp('created_at')->nullable()->default(
                DB::raw('CURRENT_TIMESTAMP()')
            );


            $table->foreign('illness_status_id')
                ->references('id')
                ->on('illness_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('illnesses');
    }
}
