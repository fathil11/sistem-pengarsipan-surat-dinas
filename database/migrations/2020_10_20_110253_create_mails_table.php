<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('directory_code');
            $table->string('code')->unique();
            $table->string('title');
            $table->string('origin');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('mail_types');
            $table->unsignedBigInteger('reference_id');
            $table->foreign('reference_id')->references('id')->on('mail_references');
            $table->unsignedBigInteger('priority_id');
            $table->foreign('priority_id')->references('id')->on('mail_priorities');
            $table->dateTimeTz('mail_created_at');
            $table->dateTimeTz('mail_updated_at');
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
        Schema::dropIfExists('mails');
    }
}
