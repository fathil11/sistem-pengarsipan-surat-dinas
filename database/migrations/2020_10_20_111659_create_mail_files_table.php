<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_files', function (Blueprint $table) {
            $table->unsignedBigInteger('mail_version_id');
            $table->foreign('mail_version_id')->references('id')->on('mail_versions');
            $table->string('original_name');
            $table->string('directory_name');
            $table->string('type');
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
        Schema::dropIfExists('mail_files');
    }
}
