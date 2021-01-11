<?php

//use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone_code', 4)->nullable()->default('7');
            $table->char('phone', 10);
            $table->string('email', 64)->nullable();
            $table->string('password', 64);
            $table->string('first_name', 32);
            $table->string('last_name', 32);
            $table->string('middle_name', 32)->nullable();

            /**
             * Auto-generated from first_name, last_name and middle_name cells.
             */
            $table->string('full_name', 98)->storedAs(
                DB::raw('CONCAT(`last_name`, \' \', `first_name`, \' \', IF(`middle_name` IS NOT NULL, `middle_name`, \'\'))')
            );

            $table->timestamp('birthday')->nullable();

            /**
             * 0 – male
             * 1 – female
             */
            $table->enum('gender', ['0', '1'])->nullable();

            /**
             * Time of last activity of patient in system.
             */
            $table->timestamp('last_activity')->nullable();
            $table->timestamp('created_at')->nullable()->default(
                DB::raw('CURRENT_TIMESTAMP()')
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
