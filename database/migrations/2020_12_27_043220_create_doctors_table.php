<?php

//use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('login', 16);
            $table->string('password', 64);
            $table->string('email', 64);
            $table->string('first_name', 32);
            $table->string('last_name', 32);
            $table->string('middle_name', 32);

            /**
             * Auto-generated from first_name, last_name and middle_name cells.
             */
            $table->string('full_name', 98)->storedAs(
                DB::raw('CONCAT(`last_name`, `first_name`, `middle_name`)')
            );

            $table->timestamp('birthday')->nullable();

            /**
             * 0 – male
             * 1 – female
             */
            $table->enum('gender', ['0', '1'])->nullable();
            $table->string('description', 2048);

            /**
             * From 0.0 to 5.0
             */
            $table->double('rating', 2, 1)->default(0.0);
            $table->date('working_since')->nullable();

            /**
             * Doctor's percent rate until evening
             */
            $table->integer('day_percent')->default(0);

            /**
             * Doctor's percent rate after evening
             */
            $table->integer('night_percent')->default(0);

            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
