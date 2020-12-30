<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_statuses', function (Blueprint $table) {
            $table->tinyInteger('id', true, true);
            $table->string('name', 32);

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
        Schema::dropIfExists('visit_statuses');
    }
}
