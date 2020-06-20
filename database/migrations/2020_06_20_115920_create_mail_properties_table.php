<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mail_id');
            $table->foreign('mail_id')->references('id')->on('mails');
            $table->unsignedBigInteger('mail_type_id');
            $table->foreign('mail_type_id')->references('id')->on('mail_types');
            $table->unsignedBigInteger('mail_reference_id');
            $table->foreign('mail_reference_id')->references('id')->on('mail_references');
            $table->unsignedBigInteger('mail_priority_id');
            $table->foreign('mail_priority_id')->references('id')->on('mail_priorities');
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
        Schema::dropIfExists('mail_properties');
    }
}
