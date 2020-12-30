<?php

// TODO: modify `visit_attachments` table for dropbox supporting

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('visit_id')->unsigned();


            $table->foreign('visit_id')
                ->references('id')
                ->on('visits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visit_attachments');
    }
}
