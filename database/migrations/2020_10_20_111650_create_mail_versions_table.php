<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_versions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mail_id');
            $table->foreign('mail_id')->references('id')->on('mails');
            // $table->string('version');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_versions');
    }
}
