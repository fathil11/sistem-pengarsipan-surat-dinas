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
            $table->enum('kind', ['in', 'out']);
            $table->string('directory_code')->nullable();
            $table->string('code')->unique()->nullable();
            $table->string('title');
            $table->string('origin');
            $table->unsignedBigInteger('mail_folder_id');
            $table->foreign('mail_folder_id')->references('id')->on('mail_folders');
            $table->unsignedBigInteger('mail_type_id');
            $table->foreign('mail_type_id')->references('id')->on('mail_types');
            $table->unsignedBigInteger('mail_reference_id');
            $table->foreign('mail_reference_id')->references('id')->on('mail_references');
            $table->unsignedBigInteger('mail_priority_id');
            $table->foreign('mail_priority_id')->references('id')->on('mail_priorities');
            $table->dateTimeTz('mail_created_at')->nullable();
            $table->dateTimeTz('mail_updated_at')->nullable();
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
