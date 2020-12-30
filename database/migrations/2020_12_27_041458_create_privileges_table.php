<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privileges', function (Blueprint $table) {
            $table->tinyInteger('id', true, true);

            /**
             * Title of privilege.
             */
            $table->string('name', 32);

            /**
             * Short description of opportunities of privilege.
             */
            $table->string('description', 256)->nullable();

            /**
             * Alias for native Laravel translation.
             */
            $table->string('lang_alias', 8);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('privileges');
    }
}
