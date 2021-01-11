<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSafeVarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('safe_vars', function (Blueprint $table) {
            $table->char('uuid', 16)->unique();
            $table->string('value', 32);
            $table->integer('destroy_time')->nullable()->default(1800);
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
        Schema::dropIfExists('safe_vars');
    }
}
